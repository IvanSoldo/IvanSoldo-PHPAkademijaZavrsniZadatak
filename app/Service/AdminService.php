<?php

namespace App\Service;

use App\Repository\AdminRepository;

class AdminService {

    private $adminRepository;

    public function __construct() {

        $this->adminRepository = new AdminRepository();

    }

    public function checkProductData($data) {

        if (empty($data['productName'])) {
            $data['productNameError'] = 'Please enter product name';
        } else {
            if ($this->adminRepository->doesProductExist($data['productName'])) {
                $data['productNameError'] = 'Product already exists!';
            }
        }

        if (empty($data['productPrice'])) {
            $data['productPriceError'] = 'Please enter product price';
        }

        if (empty($data['productDescription'])) {
            $data['productDescriptionError'] = 'Please enter product description';
        }

        if (empty($data['productCategory'])) {
            $data['productCategoryError'] = 'Please enter product category';
        } else {
            if (!$this->adminRepository->doesProductCategoryExist($data['productCategory'])) {
                $data['productCategoryError'] = 'Category not found';
            }

        }

       if (empty($data['productImage']['name'])) {
           $data['productImageError'] = 'Image is required';
       } else {
           if (!$this->isImage($data['productImage']['tmp_name'])) {
               $data['productImageError'] = 'Only images allowed.';
           } else if ($data['productImage']['size'] > 65535) {
               $data['productImageError'] = 'Maximum size of image is 64 KB.';
           } else if($data['productImage']['errors'] != 0) {
               $data['productImageError'] = 'Something went wrong with image upload.';
           }
       }



        return $data;

    }

    private function isImage($img){
        return (bool)getimagesize($img);
    }



}