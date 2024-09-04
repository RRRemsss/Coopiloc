<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class PdfGeneratorService
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function generatePdf(string $template, array $context)
    {
        // Set Dompdf options
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Generate from Twig to HTML
        $html = $this->twig->render($template, $context);

        // Load the HTML in Dompdf
        $dompdf->loadHtml($html);

        // Set display of the document
        $dompdf->setPaper('A4', 'portrait');

        // Generate the PDF
        $dompdf->render();

        // Output the generated PDF content
        return $dompdf->output();
    }
}