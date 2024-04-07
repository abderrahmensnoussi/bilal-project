<?php

namespace App\Service;

Class EmploiTempsService
{

    public function SessionToEmploiTemps ($sessions) {
        $result = [];

        $daysFr = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
            7 => 'Dimanche',
        ];

        foreach ($sessions as $data) {
            $dayOfWeek = $daysFr[$data->getDateSession()->format('N')];
            $dateSession1 = clone $data->getDateSession();
            $dateSession2 = clone $data->getDateSession();
            $startOfWeek = ($dateSession1->format('N') != 1) ? $dateSession1->modify('last monday')->format('d/m/Y') : $dateSession1->format('d/m/Y');
            $endOfWeek = ($dateSession2->format('N') != 7) ? $dateSession2->modify('next sunday')->format('d/m/Y') : $dateSession2->format('d/m/Y');

            $weekKey = $startOfWeek . '_' . $endOfWeek;
            if (!isset($result[$weekKey])) {
                $result[$weekKey] = [];
            }

            if (!isset($result[$weekKey][$dayOfWeek . '_' . $data->getDateSession()->format('d/m/Y')])) {
                $result[$weekKey][$dayOfWeek . '_' . $data->getDateSession()->format('d/m/Y')] = [];
            }

            $result[$weekKey][$dayOfWeek . '_' . $data->getDateSession()->format('d/m/Y')][] = $data;
        }

        return $result;
    }

}