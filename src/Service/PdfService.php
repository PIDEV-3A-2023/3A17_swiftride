<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new Dompdf();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function generatePdfFile(string $html): string
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->setPaper('A3', 'portrait');
        $this->domPdf->render();

        return $this->domPdf->output();
    }

    public function showPdfFile($html)
{
    $this->domPdf->loadHtml($html);
    $this->domPdf->render();
    $this->domPdf->stream("details.pdf", [
        'Attachment' => false
    ]);
}


    public function generateBinaryPDF($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->output();
    }
}
