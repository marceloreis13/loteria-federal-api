<?php

namespace LoteriaApi\Provider\Routes;

use Silex\Application;
use Silex\ControllerProviderInterface;  

class IndexControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        // API
        $controllers->get('/', function () use ($app) {
            $loteria = $app['request']->get('loteria');
            $concurso = $app['request']->get('concurso');
            $latest = $app['request']->get('latest');

            try {
                $loteria = $app['factory']->getLoteria($loteria);

                if (!$concurso && !$latest) {
                    $result = $loteria->findLastConcurso();    
                } else if ($concurso) {
                    $result = $loteria->findByConcurso($concurso);
                } else if ($latest) {
                    $result = $loteria->findLatestConcursos($latest);
                }
                
                return $app->json($result, 200);
            } catch (\Exception $e) {
                return $app->abort(400);
            }
        });

        return $controllers;
    }
}
