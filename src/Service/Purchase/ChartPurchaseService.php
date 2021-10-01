<?php

namespace App\Service\Purchase;

use App\Repository\ArticleRepository;
use DateInterval;
use DateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart; 

class ChartPurchaseService{

    protected $session;
    protected $articleRepository;
    private $entityManager;

    public function __construct(SessionInterface $session,ArticleRepository $articleRepository,$entityManager)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function mixedChartOneUser(ChartBuilderInterface $chartBuilder,$purchase){
        $mixed=$chartBuilder->createChart(Chart::TYPE_BAR);

        $labels = [];
        $tots = [];
        $moy = 0;

        foreach($purchase as $purchy){
            $labels[] = 'commande n° '.$purchy->getId();
            $tots[] = $purchy->getTotal();
        }

        for($i=0;$i<count($tots);$i++){
            $moy += $tots[$i];
        }

        $moyenne = $moy / count($tots);
        $dataMoyenne = [];

        for($i=0;$i<count($tots);$i++){
            $dataMoyenne[]=$moyenne;
        }

        $mixed->setData([
            'labels'=> $labels,
              'datasets'=> [[
                'type'=> 'bar',
                'label'=> 'Prix de commande',
                'data'=> $tots,
                'borderColor'=> 'rgb(255, 99, 132)',
                'backgroundColor'=> 'rgba(255, 99, 132, 0.2)'
              ], [
                'type'=> 'line',
                'label'=> 'Prix moyen de commande',
                'data'=> $dataMoyenne,
                'fill'=> false,
                'borderColor'=> 'rgb(54, 162, 235)'
              ]]
              ]);

            $mixed->setOptions([
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0]],
                    ],
                ],
            ]);
              
        return $mixed;
    }

    public function barChartPastYear(ChartBuilderInterface $chartBuilder,$purchase){
        $line=$chartBuilder->createChart(Chart::TYPE_BAR);
        
        $interval = new DateInterval('P1M');
        $target = new DateTime();
        $cloned = clone $target;
        $cloned->modify('-1 year');
        
        $monthArrayLabel= [];
        $monthlyTotal=[];
        $total =0;

        $formatDate='m,Y';

        for($i=0;$i<=11;$i++){

            if($i===0){
                
                $monthArrayLabel[]=$cloned->format('M,Y');
                $this->boucleChart($cloned,$purchase,$total,$formatDate);
                $monthlyTotal[] = $this->boucleChart($cloned,$purchase,$total,$formatDate);;
                $total = 0;
                
            } else {
                
                $cloned->add($interval);
                $monthArrayLabel[]=$cloned->format('M,Y');
                $this->boucleChart($cloned,$purchase,$total,$formatDate);
                $monthlyTotal[] = $this->boucleChart($cloned,$purchase,$total,$formatDate);;
                $total = 0;

            }
        }

        $line->setData([
            'labels'=> $monthArrayLabel,
              'datasets'=> [[
                'label'=> 'Total des ventes',
                'data'=> $monthlyTotal,
                'borderColor'=> 'rgb(255, 99, 132)',
                'backgroundColor'=> 'rgba(255, 99, 132, 0.2)'
              ]]
              ]);

            $line->setOptions([
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['min' => 0]],
                    ],
                ],
            ]);

            return $line;
    }

    public function barChartPastMonth(ChartBuilderInterface $chartBuilder,$purchase){

        $sticks = $chartBuilder->createChart(Chart::TYPE_BAR);
        
        $interval = new DateInterval('P1D');
        $target = new DateTime();
        $clonedA = clone $target;
        $clonedA->modify('-1 month');
        $clonedB = clone $target;
        $clonedB->modify('-1 month');

        $monthLabel= [];
        $dailyTotal=[];
        $total =0;

        $dayInMonth=[
            'Jan'=>31,
            'Feb'=>28,
            'Mar'=>31,
            'Apr'=>30,
            'May'=>31,
            'Jun'=>30,
            'Jul'=>31,
            'Aug'=>31,
            'Sep'=>30,
            'Oct'=>31,
            'Nov'=>30,
            'Dec'=>31
        ];
        $formatDate = 'd,M';

        foreach($dayInMonth as $key => $nbDays){
            
            if($clonedB->format('M') === $key){
                
                for($i=0;$i<=$nbDays;$i++){
                    
                    if($i===0){
        
                        $monthLabel[]=$clonedA->format('d,M');
                        $this->boucleChart($clonedA,$purchase,$total,$formatDate);
                        $dailyTotal[] = $this->boucleChart($clonedA,$purchase,$total,$formatDate);
                        $total = 0;
                        
                        
                    } else {
                        
                        $clonedA->add($interval);
                        $monthLabel[]=$clonedA->format('d,M');
                        $dailyTotal[] = $this->boucleChart($clonedA,$purchase,$total,$formatDate);
                        $total = 0;
                        
                    }
                }
                
            } else {
                continue;
            }
        }
    
        $sticks->setData([
            'labels'=>$monthLabel,
            'datasets'=>[
                [
                    'label' => 'Total journalier',
                    'backgroundColor' => 'rgb(0, 0, 255,0.5)',
                    'data' => $dailyTotal,
                ]
            ]
            ]);
        $sticks->setOptions([
           'scales' => [
               'yAxes' => [
                   ['ticks' => ['min' => 0]],
                ],
            ],
        ]);

        return $sticks;
    }

    public function boucleChart($cloned,$purchase,$total,$formatDate){
        
            foreach($purchase as $purchy){
                if($purchy->getCreatedAt()->format($formatDate)==$cloned->format($formatDate)){
                    $total += $purchy->getTotal();
                } else {
                    continue;
                }
                
            }
            return $total;
    }
}