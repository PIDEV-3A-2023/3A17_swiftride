<?php
 
 namespace App\Service;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeGenerator extends AbstractController
{
            public function GenerateQrcode(): array
        {
            $writer = new PngWriter();
            $qrCode = QrCode::create('https://www.binaryboxtuts.com/')
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(120)
                ->setMargin(0)
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
            $logo = Logo::create('img/logo.png')
                ->setResizeToWidth(60);
            $label = Label::create('')->setFont(new NotoSans(8));
     
            $qrCodes = [];
            $qrCodes['img'] = $writer->write($qrCode, $logo)->getDataUri();
            $qrCodes['simple'] = $writer->write(
                                    $qrCode,
                                    null,
                                    $label->setText('Simple')
                                )->getDataUri();
     
            $qrCode->setForegroundColor(new Color(255, 0, 0));
            $qrCodes['changeColor'] = $writer->write(
                $qrCode,
                null,
                $label->setText('Color Change')
            )->getDataUri();
     
            $qrCode->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 0, 0));
            $qrCodes['changeBgColor'] = $writer->write(
                $qrCode,
                null,
                $label->setText('Background Color Change')
            )->getDataUri();
     
            $qrCode->setSize(200)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));
            $qrCodes['withImage'] = $writer->write(
                $qrCode,
                $logo,
                $label->setText('With Image')->setFont(new NotoSans(20))
            )->getDataUri();
            return $qrCodes;
         
    }   
}
  