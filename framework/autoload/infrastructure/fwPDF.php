<?php

class fwPDF {

    var $_fileName;
    var $_orientation;
    var $_format;
    var $_margins;
    var $_header;
    var $_footer;

    public function __construct($strTemplate, $strFileName = "print.pdf", $orientation = "P", $format = "A4", $unit = "mm") {
        $this->_template = $strTemplate;
        $this->_fileName = fwPDF::fixExtension($strFileName);
        $this->_orientation = $orientation;
        $this->_format = ($format == "A4" ? ($orientation == "P" ? "A4" : "A4-L") : $format);
        $this->_unit = $unit;
        $this->_header = null;
        $this->_footer = null;
        $this->_margins = array(
            "left"      => 5,
            "right"     => 5,
            "top"       => 5,
            "bottom"    => 5,
            "header"    => 0,
            "footer"    => 0,
        );
    }

    function setHeader($header) {
        $this->_header = $header;
    }

    function setFooter($footer) {
        $this->_footer = $footer;
    }

    function setMargins($marginTop = null, $marginRight = null, $marginBottom = null, $marginLeft = null, $marginHeader = null, $marginFooter = null) {
        if ($marginTop !== null) {
            $this->_margins["top"] = $marginTop;
        }

        if ($marginRight !== null) {
            $this->_margins["right"] = $marginRight;
        }

        if ($marginBottom !== null) {
            $this->_margins["bottom"] = $marginBottom;
        }

        if ($marginLeft !== null) {
            $this->_margins["left"] = $marginLeft;
        }

        if ($marginHeader !== null) {
            $this->_margins["header"] = $marginHeader;
        }

        if ($marginFooter !== null) {
            $this->_margins["footer"] = $marginFooter;
        }
    }

    function getPDF() {
        ini_set("memory_limit", "1024M");

        include_once(PATH_GLOBAL_AUTO . "libs/mpdf/mpdf.php");
        $mpdf = new mPDF("C" , $this->_format,  "", "", $this->_margins["left"], $this->_margins["right"], $this->_margins["top"], $this->_margins["bottom"], $this->_margins["header"], $this->_margins["footer"], $this->_orientation);
        $mpdf->SetDisplayMode("fullpage");
        $mpdf->list_indent_first_level = 0;

        if ($this->_header != null) {
            $mpdf->setHTMLHeader($this->_header);
        }

        if ($this->_footer != null) {
            $mpdf->setHTMLFooter($this->_footer);
        }

        $mpdf->WriteHTML($this->_template);
        return $mpdf->Output("", "S");
    }

    function output() {

        include_once(PATH_GLOBAL_AUTO . "libs/mpdf/mpdf.php");
        $mpdf = new mPDF("C" , $this->_format,  "", "", $this->_margins["left"], $this->_margins["right"], $this->_margins["top"], $this->_margins["bottom"], $this->_margins["header"], $this->_margins["footer"], $this->_orientation);
        $mpdf->SetDisplayMode("fullpage");
        $mpdf->list_indent_first_level = 0;

        if ($this->_header != null) {
            $mpdf->setHTMLHeader($this->_header);
        }

        if ($this->_footer != null) {
            $mpdf->setHTMLFooter($this->_footer);
        }

        $mpdf->WriteHTML("Hello World");
        print_R($mpdf);
        $mpdf->Output($this->_fileName, "D");
        exit;
    }

    function save() {
        ini_set("memory_limit", "1024M");

        include_once(PATH_GLOBAL_AUTO . "libs/mpdf/mpdf.php");
        $mpdf = new mPDF("C" , $this->_format,  "", "", $this->_margins["left"], $this->_margins["right"], $this->_margins["top"], $this->_margins["bottom"], $this->_margins["header"], $this->_margins["footer"], $this->_orientation);
        $mpdf->SetDisplayMode("fullpage");
        $mpdf->list_indent_first_level = 0;

        if ($this->_header != null) {
            $mpdf->setHTMLHeader($this->_header);
        }

        if ($this->_footer != null) {
            $mpdf->setHTMLFooter($this->_footer);
        }

        $mpdf->WriteHTML($this->_template);
        $mpdf->Output($this->_fileName, "F");
    }

    // PUBLIC STATIC METHODS
    public static function outputPDF($fileName, &$data) {
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=" . fwPDF::fixExtension($fileName));
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . strlen($data));
        header("Accept-Ranges: bytes");
        print $data;
        exit;
    }

    public static function mergePDFStrings($strings) {
        $fnames = array();

        foreach ($strings as $s) {
            $fname = tempnam(sys_get_temp_dir(), "fwPDF_merge_strings");

            $h = fopen($fname, "wb");
            fwrite($h, $s);
            fclose($h);

            $fnames[] = $fname;
        }

        $merged = fwPDF::mergePDFFiles($fnames);

        foreach ($fnames as $fname) {
            unlink($fname);
        }

        return $merged;
    }

    public static function mergePDFFiles($files) {
        include_once(PATH_GLOBAL_AUTO . "libs/PDFMerger/PDFMerger.php");

        $pdf = new PDFMerger;

        foreach ($files as $f) {
            $pdf->addPDF($f, "all");
        }

        return $pdf->merge("string");
    }

    public static function fixExtension($fileName) {
        if (substr(strtolower($fileName), -4, 4) != ".pdf") {
            $fileName .= ".pdf";
        }

        return $fileName;
    }
}