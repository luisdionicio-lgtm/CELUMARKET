<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Ejecutar los seeds de la base de datos.
     */
    public function run(): void
    {
            Product::query()->delete(); // Limpia la tabla
            Product::create([
            'id' => 40014,
            'name' => 'iPhone 13 128GB',
            'brand' => 'Apple',
            'price' => 2399,
            'image_url' => 'https://media.falabella.com/falabellaPE/115929054_01/w=800,h=800,fit=pad',
            'rating' => 4.7,
            'storage' => '128GB',
            'ram' => '4GB',
            'processor' => 'A15 Bionic',
            'camera' => '12MP Dual',
            'screen' => '6.1" Super Retina XDR',
            'battery' => '3240mAh',
            'in_stock' => true,
            'featured' => true,
        ]);
        Product::create([
            'id' => 40029,
            'name' => 'iPhone 15 128GB',
            'brand' => 'Apple',
            'price' => 3599,
            'image_url' => 'https://claroperupoc.vtexassets.com/arquivos/ids/1893470/iphone-15-blue-cable-usbc-legal.png?v=638774740543100000',
            'rating' => 4.9,
            'storage' => '128GB',
            'ram' => '6GB',
            'processor' => 'A16 Bionic',
            'camera' => '48MP Dual',
            'screen' => '6.1" Super Retina XDR',
            'battery' => '3349mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 40032,
            'name' => 'iPhone 15 Pro 128GB',
            'brand' => 'Apple',
            'price' => 4599,
            'image_url' => 'https://spellboundelectronics.com/wp-content/uploads/2023/09/2.png',
            'rating' => 4.9,
            'storage' => '128GB',
            'ram' => '8GB',
            'processor' => 'A17 Pro',
            'camera' => '48MP Pro Triple',
            'screen' => '6.1" Super Retina XDR',
            'battery' => '3274mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 50010,
            'name' => 'Poco C65 128GB',
            'brand' => 'Poco',
            'price' => 599,
            'image_url' => 'https://i.blogs.es/2034d1/original-14-/650_1200.jpeg',
            'rating' => 4.2,
            'storage' => '128GB',
            'ram' => '6GB',
            'processor' => 'MediaTek Helio G85',
            'camera' => '50MP Dual',
            'screen' => '6.74" HD+',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => false,
        ]);

        Product::create([
            'id' => 50020,
            'name' => 'Poco X6 5G 256GB',
            'brand' => 'Poco',
            'price' => 1299,
            'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3frumrd1i7T9vcx_KJHA4B_O5Sqs1X4nK0g&s',
            'rating' => 4.5,
            'storage' => '256GB',
            'ram' => '8GB',
            'processor' => 'Snapdragon 7s Gen 2',
            'camera' => '64MP Triple',
            'screen' => '6.67" AMOLED 120Hz',
            'battery' => '5100mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 50030,
            'name' => 'Poco F6 5G 256GB',
            'brand' => 'Poco',
            'price' => 1899,
            'image_url' => 'https://i02.appmifile.com/mi-com-product/fly-birds/poco-f6/M/59600b31a4d4408e171ab79207805b4e.jpg',
            'rating' => 4.7,
            'storage' => '256GB',
            'ram' => '12GB',
            'processor' => 'Snapdragon 8s Gen 3',
            'camera' => '50MP Triple OIS',
            'screen' => '6.67" AMOLED 120Hz',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 60014,
            'name' => 'Honor X8B 256GB',
            'brand' => 'Honor',
            'price' => 899,
            'image_url' => 'https://http2.mlstatic.com/D_NQ_NP_950696-MPE81429800423_122024-O-honor-x8b-256gb-8gb-ram.webp',
            'rating' => 4.3,
            'storage' => '256GB',
            'ram' => '8GB',
            'processor' => 'Snapdragon 680',
            'camera' => '108MP Triple',
            'screen' => '6.7" AMOLED 90Hz',
            'battery' => '4500mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 60026,
            'name' => 'Honor X9B 5G 256GB',
            'brand' => 'Honor',
            'price' => 1399,
            'image_url' => 'https://www.honor.com/content/dam/honor/my/products/smartphone/honor-x9b/pcp/HONOR-X9b.png',
            'rating' => 4.6,
            'storage' => '256GB',
            'ram' => '8GB',
            'processor' => 'Snapdragon 6 Gen 1',
            'camera' => '108MP Triple',
            'screen' => '6.78" AMOLED 120Hz',
            'battery' => '5800mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 70012,
            'name' => 'Oppo A18 128GB',
            'brand' => 'Oppo',
            'price' => 549,
            'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSINuZefgetiiEBDhbVv8WCPYwyQbWzlGEspg&s',
            'rating' => 4.2,
            'storage' => '128GB',
            'ram' => '4GB',
            'processor' => 'MediaTek Helio G85',
            'camera' => '8MP Dual',
            'screen' => '6.56" HD+ 90Hz',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => false,
        ]);

        Product::create([
            'id' => 70025,
            'name' => 'Oppo Reno11 5G 256GB',
            'brand' => 'Oppo',
            'price' => 1699,
            'image_url' => 'https://consumer.huawei.com/dam/content/dam/huawei-cbg-site/common/mkt/pdp/admin-image/phones/nova-y61/specs/specs-img.png',
            'rating' => 4.6,
            'storage' => '256GB',
            'ram' => '8GB',
            'processor' => 'MediaTek Dimensity 7050',
            'camera' => '50MP Triple',
            'screen' => '6.7" AMOLED 120Hz',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 90012,
            'name' => 'Huawei Nova Y61 128GB',
            'brand' => 'Huawei',
            'price' => 549,
            'image_url' => 'https://consumer.huawei.com/dam/content/dam/huawei-cbg-site/common/mkt/pdp/admin-image/phones/nova-y61/specs/specs-img.png',
            'rating' => 4.1,
            'storage' => '128GB',
            'ram' => '6GB',
            'processor' => 'Snapdragon 680',
            'camera' => '50MP Triple',
            'screen' => '6.52" HD+',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => false,
            ]);
        Product::create([
        'id' => 20012,
        'name' => 'Redmi 13C 128GB',
        'brand' => 'Xiaomi',
        'price' => 549,
        'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxVxn0dXmKAQj4orBwKnBJq8CNvk_TJzXs-g&s',
        'rating' => 4.2,
        'storage' => '128GB',
        'ram' => '4GB',
        'processor' => 'MediaTek Helio G85',
        'camera' => '50MP Dual',
        'screen' => '6.74" HD+',
        'battery' => '5000mAh',
        'in_stock' => true,
        'featured' => false,
        ]);

Product::create([
    'id' => 20024,
    'name' => 'Redmi Note 13 128GB',
    'brand' => 'Xiaomi',
    'price' => 899,
    'image_url' => 'https://i.blogs.es/1e762e/redmi-note-13-5g-1/650_1200.jpeg',
    'rating' => 4.4,
    'storage' => '128GB',
    'ram' => '6GB',
    'processor' => 'Snapdragon 685',
    'camera' => '108MP Triple',
    'screen' => '6.67" AMOLED 120Hz',
    'battery' => '5000mAh',
    'in_stock' => true,
    'featured' => true,
]);

Product::create([
    'id' => 20034,
    'name' => 'Redmi Note 13 Pro 5G 256GB',
    'brand' => 'Xiaomi',
    'price' => 1599,
    'image_url' => 'https://i02.appmifile.com/mi-com-product/fly-birds/redmi-note-13-pro-5g/m/f13498f144b1f06b514fdb5392e9d543.jpg',
    'rating' => 4.6,
    'storage' => '256GB',
    'ram' => '8GB',
    'processor' => 'Snapdragon 7s Gen 2',
    'camera' => '200MP Triple OIS',
    'screen' => '6.67" AMOLED 120Hz',
    'battery' => '5100mAh',
    'in_stock' => true,
    'featured' => true,
]);

Product::create([
    'id' => 30015,
    'name' => 'Moto G14 128GB',
    'brand' => 'Motorola',
    'price' => 499,
    'image_url' => 'https://claroperupoc.vtexassets.com/arquivos/ids/1297578/composicion-lila-pastel-g14.png?v=638295523523470000',
    'rating' => 4.1,
    'storage' => '128GB',
    'ram' => '4GB',
    'processor' => 'Unisoc T616',
    'camera' => '50MP Dual',
    'screen' => '6.6" HD+',
    'battery' => '5000mAh',
    'in_stock' => true,
    'featured' => false,
]);

Product::create([
    'id' => 30027,
    'name' => 'Moto G54 5G 256GB',
    'brand' => 'Motorola',
    'price' => 999,
    'image_url' => 'https://cdn.movertix.com/media/catalog/product/m/o/motorola-moto-g54-5g-dual-sim-indigo-blue-256gb-and-8gb-ram-xt2343-2.jpg',
    'rating' => 4.4,
    'storage' => '256GB',
    'ram' => '8GB',
    'processor' => 'MediaTek Dimensity 7020',
    'camera' => '50MP OIS Dual',
    'screen' => '6.5" FHD+ 120Hz',
    'battery' => '5000mAh',
    'in_stock' => true,
    'featured' => true,
]);

Product::create([
    'id' => 30030,
    'name' => 'Motorola Edge 50 Fusion 256GB',
    'brand' => 'Motorola',
    'price' => 1799,
    'image_url' => 'https://claroperupoc.vteximg.com.br/arquivos/ids/2653721/moto-edge50fusion-azul-1.png',
    'rating' => 4.7,
    'storage' => '256GB',
    'ram' => '12GB',
    'processor' => 'Snapdragon 7s Gen 2',
    'camera' => '50MP Triple with OIS',
    'screen' => '6.7" pOLED 144Hz',
    'battery' => '5000mAh',
    'in_stock' => true,
    'featured' => true,
]);

        Product::create([
            'id' => 1001,
            'name' => 'Samsung A05 64GB',
            'brand' => 'Samsung',
            'price' => 499,
            'image_url' => 'https://m.media-amazon.com/images/I/717LoicbArL.jpg',
            'rating' => 4.2,
            'storage' => '64GB',
            'ram' => '4GB',
            'processor' => 'MediaTek Helio G85',
            'camera' => '50MP Dual',
            'screen' => '6.7" HD+',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => false,
        ]);

        Product::create([
            'id' => 1002,
            'name' => 'Samsung A15 128GB',
            'brand' => 'Samsung',
            'price' => 849,
            'image_url' => 'https://www.hogarfeliz.com.py/userfiles/images/productos/600/a0245636.PNG',
            'rating' => 4.4,
            'storage' => '128GB',
            'ram' => '6GB',
            'processor' => 'MediaTek Dimensity 6100+',
            'camera' => '50MP Triple',
            'screen' => '6.5" Super AMOLED',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 1003,
            'name' => 'Samsung A25 5G 128GB',
            'brand' => 'Samsung',
            'price' => 1199,
            'image_url' => 'https://http2.mlstatic.com/D_NQ_NP_786020-MLA74558592283_022024-O.webp',
            'rating' => 4.5,
            'storage' => '128GB',
            'ram' => '6GB',
            'processor' => 'Exynos 1280',
            'camera' => '50MP OIS Triple',
            'screen' => '6.5" Super AMOLED 120Hz',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::create([
            'id' => 1004,
            'name' => 'Samsung S24 Ultra 256GB',
            'brand' => 'Samsung',
            'price' => 4899,
            'image_url' => 'https://media.falabella.com/falabellaPE/128375370_01/w=800,h=800,fit=pad',
            'rating' => 4.9,
            'storage' => '256GB',
            'ram' => '12GB',
            'processor' => 'Snapdragon 8 Gen 3',
            'camera' => '200MP Quad + S Pen',
            'screen' => '6.8" Dynamic AMOLED 2X 120Hz',
            'battery' => '5000mAh',
            'in_stock' => true,
            'featured' => true,
        ]);

        Product::query()->each(function (Product $product) {
            $product->updateQuietly([
                'nombre' => $product->name,
                'precio' => $product->price,
                'stock' => $product->in_stock ? 25 : 0,
            ]);
        });
    }
}
