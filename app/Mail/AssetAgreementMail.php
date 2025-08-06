<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssetAgreementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $asset;
    public $pdfContent;

    public function __construct($user, $asset, $pdfContent)
    {
        $this->user = $user;
        $this->asset = $asset;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Asset Agreement PDF')
            ->markdown('emails.asset_agreement')
            ->attachData($this->pdfContent, "Asset_Agreement_{$this->asset->id}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
