<?php namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;

    class Product extends ResourceController
    {
        protected $format = 'json';

        /**
         * @var ProductModel
         */
        protected $productModel;

        public function __construct()
        {
            $this->productModel = new ProductModel();
        }

        /**
         * Show all products.
         */
        public function index()
        {
            $products = $this->productModel->getAllItems();

            return $this->respond([
                'success' => true,
                'data'    => $products,
            ]);
        }

        /**
         * Show a single product by id.
         */
        public function show($id = null)
        {
            if (empty($id)) {
                return $this->failValidationErrors(['id' => 'Product id is required']);
            }

            $product = $this->productModel->getItemById((int) $id);

            if (!$product) {
                return $this->failNotFound('Product not found');
            }

            return $this->respond([
                'success' => true,
                'data'    => $product,
            ]);
        }

        /**
         * Add a new product.
         */
        public function create()
        {
            $payload = $this->getRequestPayload();
            $rules   = $this->getValidationRules();

            if (!$this->validateData($payload, $rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $productId = $this->productModel->insertProduct($payload);

            if (!$productId) {
                return $this->failServerError('Failed to create product');
            }

            return $this->respondCreated([
                'success' => true,
                'message' => 'Product created successfully',
                'data'    => $this->productModel->getItemById((int) $productId),
            ]);
        }

        /**
         * Update an existing product.
         */
        public function update($id = null)
        {
            if (empty($id)) {
                return $this->failValidationErrors(['id' => 'Product id is required']);
            }

            $payload = $this->getRequestPayload();
            $rules   = $this->getValidationRules();

            if (!$this->validateData($payload, $rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $updated = $this->productModel->updateProduct($payload, (int) $id);

            if (!$updated) {
                return $this->failServerError('Failed to update product');
            }

            return $this->respond([
                'success' => true,
                'message' => 'Product updated successfully',
                'data'    => $this->productModel->getItemById((int) $id),
            ]);
        }

        /**
         * Delete a product.
         */
        public function delete($id = null)
        {
            if (empty($id)) {
                return $this->failValidationErrors(['id' => 'Product id is required']);
            }

            $deleted = $this->productModel->removeProduct((int) $id);

            if (!$deleted) {
                return $this->failServerError('Failed to delete product or product not found');
            }

            return $this->respondDeleted([
                'success' => true,
                'message' => 'Product deleted successfully',
            ]);
        }

        /**
         * Search products by keyword (?q=...)
         */
        public function search()
        {
            $keyword = (string) ($this->request->getGet('q') ?? '');

            if (trim($keyword) === '') {
                return $this->failValidationErrors(['q' => 'Search keyword is required']);
            }

            $results = $this->productModel->searchProducts($keyword);

            return $this->respond([
                'success' => true,
                'data'    => $results,
            ]);
        }

        /**
         * Normalize JSON/body payloads.
         */
        protected function getRequestPayload(): array
        {
            $jsonPayload = $this->request->getJSON(true);

            if (!empty($jsonPayload)) {
                return $jsonPayload;
            }

            return $this->request->getPost();
        }

        /**
         * Centralize product validation rules.
         */
        protected function getValidationRules(): array
        {
            return [
                'product_name'  => 'required|string|min_length[3]',
                'product_price' => 'required|decimal',
                'product_desc'  => 'required|string|min_length[5]',
                'product_size'  => 'required|string',
                'avatar'        => 'permit_empty|string',
            ];
        }
    }