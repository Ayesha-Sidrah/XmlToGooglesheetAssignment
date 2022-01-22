<?php

namespace App\Tests\DataProvider;

class DataProvider
{
    public function inputDataToExport(): array
    {
        return array(
            0 => array(
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'role',
                4 => 'team',
            ),
            1 => array(
                0 => '1',
                1 => 'Ayesha',
                2 => 'ayesha@productsup.com',
                3 => 'Developer',
                4 => 'Tech',
            ),
            2 => array(
                0 => '2',
                1 => 'Nayan',
                2 => 'nayan@productsup.com',
                3 => 'Developer',
                4 => 'Tech',
            ),
            3 => array(
                0 => '3',
                1 => 'Partha',
                2 => 'partha@productsup.com',
                3 => 'Developer',
                4 => 'Tech',
            ),
        );
    }

    public function dataExport()
    {
        return array(
                0 =>
                    array(
                        0 => 'Entity_id',
                        1 => 'CategoryName',
                        2 => 'Sku',
                        3 => 'Name',
                        4 => 'Description',
                        5 => 'Shortdesc',
                        6 => 'Price',
                        7 => 'Link',
                        8 => 'Image',
                        9 => 'Brand',
                        10 => 'Rating',
                        11 => 'CaffeineType',
                        12 => 'Count',
                        13 => 'Flavored',
                        14 => 'Seasonal',
                        15 => 'Instock',
                        16 => 'Facebook',
                        17 => 'IsKCup',
                    ),
                1 =>
                    array(
                        0 => '340',
                        1 => 'Green Mountain Ground Coffee',
                        2 => '20',
                        3 => 'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag',
                        4 => '',
                        5 => 'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.',
                        6 => '41.6000',
                        7 => 'http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html',
                        8 => 'http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg',
                        9 => 'Green Mountain Coffee',
                        10 => '0',
                        11 => 'Caffeinated',
                        12 => '24',
                        13 => 'No',
                        14 => 'No',
                        15 => 'Yes',
                        16 => '1',
                        17 => '0',
                    ),
                2 =>
                    array(
                        0 => '342',
                        1 => 'Nestle Hot Chocolate',
                        2 => '5000081171',
                        3 => 'Nestle\'s Rich Hot Chocolate 50 Packets',
                        4 => '',
                        5 => 'Nestle\'s Rich Hot Chocolate 50 Packets bulk quantity prepare 50 individual servings of milk chocolate instant hot cocoa from Nestle Hot Chocolate.',
                        6 => '11.9900',
                        7 => 'http://www.coffeeforless.com/nestles-milk-hot-chocolate-50-packets.html',
                        8 => 'http://mcdn.coffeeforless.com/media/catalog/product//n/e/nestle-hot-chocolate-mix-50-packets.png',
                        9 => 'Nestle',
                        10 => '5',
                        11 => '',
                        12 => '50',
                        13 => '',
                        14 => '',
                        15 => 'Yes',
                        16 => '1',
                        17 => '0',
                    ),
                3 =>
                    array(
                        0 => '343',
                        1 => 'Green Mountain K-Cup&reg; Coffee',
                        2 => '7602C',
                        3 => 'Green Mountain Coffee Vermont Country Blend Decaf K-Cup&reg; Coffee 96ct Medium',
                        4 => '',
                        5 => 'Green Mountain Coffee Vermont Country Blend Decaf K-Cup&amp;reg; Pods 96ct Medium case makes a balanced, mild-bodied decaf medium roast coffee from Green Mountain K-Cup&amp;reg; Pods.',
                        6 => '59.9600',
                        7 => 'http://www.coffeeforless.com/green-mountain-coffee-vermont-country-blend-decaf-k-cups-96ct-medium.html',
                        8 => 'http://mcdn.coffeeforless.com/media/catalog/product//g/r/green-mountain-coffee-vermont-country-blend-decaf-k-cups-96ct-medium-914.jpg',
                        9 => 'Green Mountain Coffee',
                        10 => '5',
                        11 => 'Decaffeinated',
                        12 => '96',
                        13 => 'No',
                        14 => 'No',
                        15 => 'Yes',
                        16 => '0',
                        17 => '1',
                    ),
                4 =>
                    array(
                        0 => '344',
                        1 => 'Tazo Tea',
                        2 => '396',
                        3 => 'Tazo Om Tea 24ct Box',
                        4 => '',
                        5 => 'Tazo Om Tea 24ct box allow you to steep 24 individual cups of flavorful, complicated ',
                        6 => '6.5000',
                        7 => 'http://www.coffeeforless.com/tazo-om-tea-24ct-box.html',
                        8 => 'http://mcdn.coffeeforless.com/media/catalog/product/images/coffeepods/tazo-om-tea-24ct-box.jpg',
                        9 => 'Tazo',
                        10 => '5',
                        11 => 'Caffeinated',
                        12 => '',
                        13 => 'No',
                        14 => 'No',
                        15 => 'No',
                        16 => '1',
                        17 => '0',
                    ),

        );
    }

    public function dataToTransformer()
    {
        yield array(
            0 => array(
                'id' => '1',
                'name' => 'Ayesha',
                'email' => 'ayesha@productsup.com',
                'role' => 'Developer',
                'team' => 'Tech',
            ),
            1 => array(
                'id' => '2',
                'name' => 'Nayan',
                'email' => 'nayan@productsup.com',
                'role' => 'Developer',
                'team' => 'Tech',
            ),
            2 => array(
                'id' => '3',
                'name' => 'Partha',
                'email' => 'partha@productsup.com',
                'role' => 'Developer',
                'team' => 'Tech',
            ),
        );
    }

}