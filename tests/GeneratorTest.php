<?php

namespace OguzcanDemircan\LaravelPromo\Tests;

use OguzcanDemircan\LaravelPromo\PromoCodeGenerator;

class GeneratorTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_uses_specified_characters_only()
    {
        $generator = new PromoCodeGenerator('1234567890', '********');
        $voucher = $generator->generate();

        $this->assertMatchesRegularExpression('/^[0-9]/', $voucher);
    }

    /** @test */
    public function it_uses_the_prefix()
    {
        $generator = new PromoCodeGenerator('1234567890', '********');
        $generator->setPrefix('beyondcode');

        $voucher = $generator->generate();

        $this->assertStringStartsWith('beyondcode-', $voucher);
    }

    /** @test */
    public function it_uses_the_suffix()
    {
        $generator = new PromoCodeGenerator('1234567890', '********');
        $generator->setSuffix('beyondcode');

        $voucher = $generator->generate();

        $this->assertStringEndsWith('-beyondcode', $voucher);
    }

    /** @test */
    public function it_uses_custom_separators()
    {
        $generator = new PromoCodeGenerator('1234567890', '********');
        $generator->setSeparator('%');
        $generator->setPrefix('beyondcode');
        $generator->setSuffix('beyondcode');

        $voucher = $generator->generate();

        $this->assertStringStartsWith('beyondcode%', $voucher);
        $this->assertStringEndsWith('%beyondcode', $voucher);
    }

    /** @test */
    public function it_generates_code_with_mask()
    {
        $generator = new PromoCodeGenerator('ABCDEFGH', '* * * *');
        $voucher = $generator->generate();

        $this->assertMatchesRegularExpression('/(.*)\s(.*)\s(.*)\s(.*)/', $voucher);
    }
}
