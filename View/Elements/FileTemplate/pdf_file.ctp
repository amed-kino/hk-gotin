<?php
$uri = array(
                            'artist' => $lyric['Artist']['name'],
                            'album'  => $lyric['Album']['title'],
                            'year'   => $lyric['Album']['year'],
                            'title'  => $lyric['Lyric']['title'],
                        );

                        $url = FULL_BASE_URL.'/gotin'.$this->HK->uri($uri);
Configure::load('tcpdf');
App::import('Vendor','xtcpdf');  
header("Content-type: application/pdf");


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.DS.'pdf-Logo.png';
                
		$this->Image($image_file, 176, 18, 15, '', 'PNG', '', 'B', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	// Page footer
	public function Footer() {


	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'ISO-8859-1', false);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HK wwww.HuneraKurdi.com');
$pdf->SetTitle($title);
$pdf->SetSubject('Gotinê strana '.$title);
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(20, 15, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// ---------------------------------------------------------

// set font
//$pdf->SetFont('times', '', 11);
$pdf->SetFont('DejaVuSerif', '', 10); 
// add a page
$pdf->AddPage();

// set some text to print
$txtHeader= $lyric['Artist']['name'].' - '.$lyric['Album']['title'].$this->HK->albumYear($lyric['Album']['year']).'<br/>';

if (isset($lyric['Lyric']['writer']) && $lyric['Lyric']['writer'] != ''){    $txtHeader .= __('Writer').':'.$lyric['Lyric']['writer'].'<br/>';}
if (isset($lyric['Lyric']['composer']) && $lyric['Lyric']['composer'] != ''){  $txtHeader .=__('Composer').':'.$lyric['Lyric']['composer'].'<br/>';}


$txtHeader .=__('Echelon').':'.$lyric['Lyric']['echelon'].'';

$txtBody=

        '<p><em>'.$lyric['Lyric']['title'].'</em><br/><br/>'
        .nl2br(h($lyric['Lyric']['text'])).'
        <p/>'
        .$this->Html->link($url).'<br><br>';


$html = '<br/><br/>'.$txtHeader.'<br/><hr/>'.$txtBody.'<br/><br/>&nbsp;<br/>&nbsp;<br/>&nbsp;';

$pdf->writeHTML($html, true, false, true, false, '');
		// Position at 15 mm from bottom
		$pdf->SetY(-44);
		// Set font
		$pdf->SetFont('DejaVuSerif', 'I', 8);

$source = $lyric['Lyric']['source'] ? __('Source of this is from').': '. $lyric['Lyric']['source'] : '';

$txtFooter= __('Written by').': '.$lyric['User']['name'].' '.$this->Time->format(
                                'd-m-Y',
                                $lyric['Lyric']['created'],
                                null
                                ).'<br/>';
if (isset($lyric['Lyric']['modified']) && $lyric['Lyric']['modified'] != '0000-00-00 00:00:00'){$txtFooter .=__('Last modified was at').': '.$this->Time->format(
                                'd-m-Y',
                                $lyric['Lyric']['modified'],
                                null
                                ).'<br/>';}
        $txtFooter .= $source.'<br/><br/>';
        $this->Html->link('www.HuneraKurdi.com','http://www.hunerakurdi.com');


// print a block of text using Write()
$pdf->writeHTML($txtFooter, true, false, true, false, '');
$pdf->Output($title, 'I');
?>
