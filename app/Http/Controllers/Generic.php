<?php

namespace App\Http\Controllers;

use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Models\Type;
use App\Models\Person;
use App\Models\Address;
use App\Models\Identification;
use App\Models\Invoice;
use GuzzleHttp\Promise\Create;


class Generic extends Controller
{

    public static function question1()
    {

        $arreglo = [];
        for ($i = 0; $i < 100; $i++) {
            array_push($arreglo, substr(str_shuffle('123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1));
        }
        return $arreglo;
    }

    public static function question2()
    {
        $numberString = self::question1();

        $arrayNumber = array();
        $string = array();

        foreach ($numberString as $numStr) {

            if (is_numeric($numStr)) {
                array_push($arrayNumber, $numStr);
            } else {
                array_push($string, $numStr);
            }
        }

        return array('number' => $arrayNumber, 'string' => $string);
    }

    public static function question3()
    {

        $arrayNumber = array_sum(self::question2()['number']);

        return 'La suma de los elementos: ' . $arrayNumber;
    }


    public static function question4()
    {
        $x = self::question2()['string'];
        sort($x);
        return $x;
    }


    public static function question5()
    {

        $person = array();
        $names = self::api('person');
        foreach ($names as $name) {
            array_push($person, $name['name']);
        }

        return $person;
    }


    public static function question6()
    {
        $genders = self::api('person');

        $e = array_filter($genders, function ($x) {
            return $x['gender'] == 'f';
        });

        return 'Existe un total de ' . count($e) . ' personas de genero femenio';
    }


    public static function question7()
    {

        $addresses = self::agrupa(self::api('address'));
        $data = array();
        foreach ($addresses as $key => $address) {
            $x = [$key, count($address)];
            array_push($data, $x);
        }
        return $data;

    }

    public static function question8()
    {
        $address = self::api('address');
        return $address;
    }

    public static function question11()
    {
        return 'Ya se encuentran creados los modelos';
    }


    public static function question12()
    {

        $countries = Country::count();
        if ($countries == 0) {
            $informations = self::CargaData('country');

            foreach ($informations as $information) {
                Country::create([
                    'code' => $information['Code'],
                    'name' => $information['Name']
                ]);
            }
            $informations = null;
        }


        $types = Type::count();
        if ($types == 0) {
            $descriptions = ['pid', 'passport', 'license'];
            foreach ($descriptions as $description) {
                Type::create([
                    'description' => $description,
                ]);
            }
        }

        $people = Person::count();
        if ($people == 0) {
            $informations = self::CargaData('person');

            foreach ($informations as $information) {
                Person::create([
                    'name' => $information['name'],
                    'lastName' => $information['last_name'],
                    'birth_date' => $information['birth_date'],
                    'gender' => $information['gender'],
                    'country_code' => $information['country']
                ]);
            }
            $informations = null;
        }

        // // $address = Address::count();
        // // if ($address == 0) {
        // //     $informations = self::CargaData('address');

        // //     foreach ($informations as $information) {
        // //         Address::create([
        // //             'person_id' => null,//intval($information['person_id']),
        // //             'country_code' => $information['country'],
        // //             'postal_code' => $information['postal_code'],
        // //             'detail' => $information['detail'],
        // //         ]);
        // //     }
        // //     $informations = null;
        // // }

        $identifications = Identification::count();
        if ($identifications == 0) {
            $informations = self::CargaData('identifications');

            foreach ($informations as $information) {
                Identification::create([
                    'person_id' => $information['person_id'],

                    'type_id' => Type::where('description', $information['type'])->get()[0]['id'],

                    'value' => $information['value'],
                ]);
            }
            $informations = null;
        }


        $invoices = Invoice::count();
        if ($invoices == 0) {
            $informations = self::CargaData('invoices');

            foreach ($informations as $information) {
                $f = Invoice::create([
                    'id' => $information['id'],
                    'identification_id' => $information['identification_id'],
                    'date' => $information['date'],
                    'total' => $information['total'],
                    'observation' => $information['observation']
                ]);
                if($f){
                    return 'error al cargar Invoice';
                }
            }
            $informations = null;
        }

        return 'data subida';
    }


    public static function CargaData($models)
    {

        $data = array();
        foreach (self::api($models) as $model) {
            array_push($data, $model);
        }
        return $data;
    }

    public static function agrupa($addresses)
    {

        $group = array();
        foreach ($addresses as $key => $address) {
            $group[$address['country']][$key] = $address['country'];
        }

        return $group;
    }


    public static function api($info)
    {

        $data = null;

        switch ($info) {
            case 'country':
                $data = Http::get('https://pkgstore.datahub.io/core/country-list/data_json/data/8c458f2d15d9f2119654b29ede6e45b8/data_json.json')->json();
                break;

            case 'person':
                $data =  Http::get('http://developers.ctdesarrollo.org/triofrio/json-dbs/persons.json')->json();
                break;

            case 'address':
                $data = Http::get('http://developers.ctdesarrollo.org/triofrio/json-dbs/addresses.json')->json();
                break;

            case 'identifications':
                $data = Http::get('http://developers.ctdesarrollo.org/triofrio/json-dbs/identifications.json')->json();
                break;

            case 'invoices':
                $data = Http::get('http://developers.ctdesarrollo.org/triofrio/json-dbs/invoices.json')->json();
                break;
        }

        return $data;
    }
}
