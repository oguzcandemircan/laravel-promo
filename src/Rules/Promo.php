<?php

namespace OguzcanDemircan\LaravelPromo\Rules;

use Illuminate\Contracts\Validation\Rule;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoAlreadyRedeemed;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoExpired;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoIsInvalid;
use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;

class Promo implements Rule
{
    protected $isInvalid = false;
    protected $isExpired = false;
    protected $wasRedeemed = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $promo = LaravelPromo::check($value);

            // Check if the Promo was already redeemed
            if (auth()->check() && $promo->users()->wherePivot('user_id', auth()->id())->exists()) {
                throw PromoAlreadyRedeemed::create($promo);
            }
        } catch (PromoIsInvalid $exception) {
            $this->isInvalid = true;

            return false;
        } catch (PromoExpired $exception) {
            $this->isExpired = true;

            return false;
        } catch (PromoAlreadyRedeemed $exception) {
            $this->wasRedeemed = true;

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        if ($this->wasRedeemed) {
            return trans('promo::validation.code_redeemed');
        }
        if ($this->isExpired) {
            return trans('promo::validation.code_expired');
        }

        return trans('promo::validation.code_invalid');
    }
}
