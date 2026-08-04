<?php

namespace App\Enums;

enum EmailType: string
{
    case Welcome            = 'welcome';
    case FirstInvoice       = 'first_invoice';
    case GstFeatures        = 'gst_features';
    case PremiumUpgrade     = 'premium_upgrade';
    case ProductivityTips   = 'productivity_tips';
    case AnnualDiscount     = 'annual_discount';

    /**
     * Delay in minutes from registration for each step.
     */
    public function delayInMinutes(): int
    {
        return match ($this) {
            self::Welcome          => 0,
            self::FirstInvoice     => 24 * 60,
            self::GstFeatures      => 3 * 24 * 60,
            self::PremiumUpgrade   => 7 * 24 * 60,
            self::ProductivityTips => 15 * 24 * 60,
            self::AnnualDiscount   => 30 * 24 * 60,
        };
    }

    public function subject(): string
    {
        return match ($this) {
            self::Welcome          => 'Welcome to InvoiceZy 🎉',
            self::FirstInvoice     => 'Create your first invoice in under 2 minutes',
            self::GstFeatures      => 'GST, PDF exports & branding — all in InvoiceZy',
            self::PremiumUpgrade   => 'Unlock Premium features on InvoiceZy',
            self::ProductivityTips => '5 tips to save hours on invoicing',
            self::AnnualDiscount   => 'Limited: Save on your Annual InvoiceZy plan',
        };
    }

    public function view(): string
    {
        return match ($this) {
            self::Welcome          => 'emails.welcome',
            self::FirstInvoice     => 'emails.first-invoice',
            self::GstFeatures      => 'emails.gst-features',
            self::PremiumUpgrade   => 'emails.premium-upgrade',
            self::ProductivityTips => 'emails.productivity-tips',
            self::AnnualDiscount   => 'emails.annual-discount',
        };
    }
}
