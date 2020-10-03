<?php

namespace App\Service;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;

class AdminService
{

    private $productRepository;
    private $orderRepository;

    public function __construct()
    {

        $this->productRepository = new ProductRepository();
        $this->orderRepository = new OrderRepository();

    }

    public function checkProductData($data)
    {

        if (empty($data['productName'])) {
            $data['productNameError'] = 'Please enter product name';
        } else {
            if ($this->productRepository->doesProductExist($data['productName'])) {
                $data['productNameError'] = 'Product already exists!';
            }
        }

        if (empty($data['productPrice'])) {
            $data['productPriceError'] = 'Please enter product price';
        } else {
            if (is_numeric($data['productPrice'])) {
                $data['productPrice'] = floatval($data['productPrice']);
            } else {
                $data['productPriceError'] = 'Price must be a number';
            }

        }

        if (empty($data['productDescription'])) {
            $data['productDescriptionError'] = 'Please enter product description';
        }


        if (empty($data['chosenCategories'])) {
            $data['productCategoryError'] = 'At least one category has to be selected.';
        }

        if (empty($data['productImageBlob'])) {
            $data['productImageError'] = 'Image is required';
        } else {
            if (!$this->isImage($data['productImageBlob'])) {
                $data['productImageError'] = 'Only images allowed.';
            } else if ($data['productImageSize'] > 65535) {
                $data['productImageError'] = 'Maximum size of image is 64 KB.';
            } else if ($data['productImageErr'] != 0) {
                $data['productImageError'] = 'Something went wrong with image upload.';
            }
        }
        return $data;
    }

    private function isImage($img)
    {
        return (bool)getimagesize($img);
    }

    public function isRadioButtonSet($categories)
    {
        if (isset($_POST['categories'])) {
            return $categories = $_POST['categories'];
        }
    }

    public function getCategories()
    {
        return $this->productRepository->getCategories();
    }

    public function isProductDataValid($data)
    {
        if (empty($data['productNameError']) && empty($data['productPriceError']) && empty($data['productCategoryError']) && empty($data['productImageError'])) {
            return true;
        }
        return false;
    }

    public function addProduct($data)
    {
        $this->productRepository->insertProduct($data);
    }


    public function changeProductStatus($data, $id)
    {
        $status = 1;
        if (isset($_GET['Activate'])) {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]->id == $id) {
                    $this->productRepository->changeStatus($data[$i]->id, $status);
                }
            }
        }
        if (isset($_GET['Deactivate'])) {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]->id == $id) {
                    $status = 0;
                    $this->productRepository->changeStatus($data[$i]->id, $status);
                }
            }
        }
    }

    public function getAllOrders() {

        return $this->orderRepository->getAllOrders();
    }

    public function printAllOrders() {
        if (isset($_POST['print'])) {
            $orders = $this->orderRepository->getAllOrders();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=data.csv');
            $output = fopen('php://output', 'w');
            fputcsv($output, array('order id','order date','customer name', 'address'),";");

            for ($i=0;$i<count($orders);$i++) {
                $csv[$i] = array($orders[$i]->id,$orders[$i]->orderDate,$orders[$i]->fullName,$orders[$i]->orderAddress);
                fputcsv($output, $csv[$i], ";");
            }
            fclose($output);

        }


    }


}