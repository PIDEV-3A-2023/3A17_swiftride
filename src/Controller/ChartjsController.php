<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\AccidentRepository;




class ChartjsController extends AbstractController
{
    #[Route('/chartjs', name: 'app_chartjs')]
    public function index(AccidentRepository $accidentRepository,ChartBuilderInterface $chartBuilder): Response
    {
          
        $dailyResults = $accidentRepository->getCountByYear();
         // Store data in arrays
         $years = array();
         $counts = array();
 
         foreach ($dailyResults as $row) {
             $years[] = $row['year'];
             $counts[] = $row['count'];
         }
 
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' =>  $years,
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $counts,
                ],
            ],
        ]);
        
        $chart->setOptions([]);

        return $this->render('chartjs/index.html.twig', [
            'controller_name' => 'ChartjsController',
            'chart' => $chart,
        ]);
    }
}
