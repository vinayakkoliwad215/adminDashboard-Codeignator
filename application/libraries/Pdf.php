<?php
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    public function loadHtml($html)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $this->dompdf = new Dompdf($options);
        $this->dompdf->loadHtml($html);
    }

    public function render()
    {
        $this->dompdf->render();
    }

    public function stream($filename = "document.pdf", $options = [])
    {
        $this->dompdf->stream($filename, $options);
    }
}
