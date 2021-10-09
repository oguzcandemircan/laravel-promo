<?php

namespace OguzcanDemircan\LaravelPromo\Rules;

use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;
use Illuminate\Contracts\Validation\Rule;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoExpired;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoIsInvalid;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoAlreadyRedeemed;

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
            $Promo = LaravelPromo::check($value);

            // Check if the Promo was already redeemed
            if (auth()->check() && $Promo->users()->wherePivot('user_id', auth()->id())->exists()) {
                throw PromoAlreadyRedeemed::create($Promo);
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
     *
     * @return string
     */
    public function message()
    {
        if ($this->wasRedeemed) {
            return trans('OguzcanDemircan\LaravelPromo\Facades\LaravelPromo::validation.code_redeemed');
        }
        if ($this->isExpired) {
            return trans('OguzcanDemircan\LaravelPromo\Facades\LaravelPromo::validation.code_expired');
        }
        return trans('OguzcanDemircan\LaravelPromo\Facades\LaravelPromo::validation.code_invalid');
    }
}
