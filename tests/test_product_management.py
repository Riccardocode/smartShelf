import unittest
import requests
import os

class TestProductCreation(unittest.TestCase):
    def setUp(self):
        self.base_url = 'http://localhost:8081/smartshelf'  # Adjust the URL to match your environment
        self.create_product_url = self.base_url + "/product_management/controllers/processAddProduct.php"
        self.uploads_dir = 'c:/xampp/htdocs/smartshelf/uploads/'
        self.shelf_id = '1' 
        self.session = requests.Session()
        
        # Create a sample image file for testing
        self.image_path = os.path.join(self.uploads_dir, 'test_image.jpg')
        with open(self.image_path, 'wb') as f:
            f.write(os.urandom(1024))  # 1KB random content

        # Login
        response = self.session.post(f'{self.base_url}/login.php', data={'username': 'test@user.com', 'password': 'testuser'})
        self.assertEqual(response.status_code, 200, "Login failed, please check login details")

    def tearDown(self):
        # Clean up uploaded test image
        if os.path.exists(self.image_path):
            os.remove(self.image_path)

    def test_shelf_exists(self):
        response = self.session.get(f'{self.base_url}/shelf_management/views/singleShelf.php?shelfID={self.shelf_id}')
        self.assertEqual(response.status_code, 200, "Shelf does  exist")

    # def test_user_permission(self):
    #     response = self.session.get(f'{self.base_url}/path/to/permission/check?shelfID={self.shelf_id}')
    #     self.assertEqual(response.status_code, 200, "User does not have permission")

    def test_create_product_with_image_upload(self):
        # Prepare the data
        data = {
            'name': 'Test Product',
            'category': 'Test Category',
            'initialQuantity': 10,
            'currentQuantity': 10,
            'buyDate': '2022-01-01',
            'expiringDate': '2022-12-31',
            'price': 9.99,
            'templateImagePath': ''
        }

        # Prepare the files
        with open(self.image_path, 'rb') as img_file:
            files = {
                'imgProduct': ('test_image.jpg', img_file, 'image/jpeg')
            }

            # Send the POST request
            response = self.session.post(f'{self.create_product_url}?shelfID={self.shelf_id}', data=data, files=files, verify=False)
            print("Response Status Code:", response.status_code)
            print("Response Headers:", response.headers)
            print("Response Text:", response.text)

        # Check the response status code
        self.assertEqual(response.status_code, 200, "Failed to create product, received status code: " + str(response.status_code))

        # Check the response content
        self.assertNotIn('Error', response.text)

    def test_create_product_with_template_image(self):
        # Prepare the data
        data = {
            'name': 'Test Product with Template Image',
            'category': 'Test Category',
            'initialQuantity': 10,
            'currentQuantity': 10,
            'buyDate': '2022-01-01',
            'expiringDate': '2022-12-31',
            'price': 9.99,
            'templateImagePath': 'default-product.png'
        }

        # Send the POST request
        response = self.session.post(f'{self.create_product_url}?shelfID={self.shelf_id}', data=data, verify=False)
        print("Response Status Code:", response.status_code)
        print("Response Headers:", response.headers)
        print("Response Text:", response.text)

        # Check the response status code
        self.assertEqual(response.status_code, 200, "Failed to create product with template image, received status code: " + str(response.status_code))

        # Check the response content
        self.assertNotIn('Error', response.text)

    def test_invalid_file_format(self):
        # Prepare the data
        data = {
            'name': 'Test Product with Invalid File Format',
            'category': 'Test Category',
            'initialQuantity': 10,
            'currentQuantity': 10,
            'buyDate': '2022-01-01',
            'expiringDate': '2022-12-31',
            'price': 9.99,
            'templateImagePath': ''
        }

        # Prepare an invalid file format
        invalid_image_path = os.path.join(self.uploads_dir, 'test_image.txt')
        with open(invalid_image_path, 'w') as f:
            f.write('This is a text file, not an image.')

        with open(invalid_image_path, 'rb') as invalid_file:
            files = {
                'imgProduct': ('test_image.txt', invalid_file, 'text/plain')
            }

            # Send the POST request
            response = self.session.post(f'{self.create_product_url}?shelfID={self.shelf_id}', data=data, files=files, verify=False)
            print("Response Status Code:", response.status_code)
            print("Response Headers:", response.headers)
            print("Response Text:", response.text)

        # Check the response status code
        self.assertEqual(response.status_code, 200, "Failed with invalid file format, received status code: " + str(response.status_code))

        # Check the response content for error message
        self.assertIn('Error: Invalid file format', response.text)

        # Clean up the invalid test file
        os.remove(invalid_image_path)

    def test_file_size_limit(self):
        # Prepare the data
        data = {
            'name': 'Test Product with Large File',
            'category': 'Test Category',
            'initialQuantity': 10,
            'currentQuantity': 10,
            'buyDate': '2022-01-01',
            'expiringDate': '2022-12-31',
            'price': 9.99,
            'templateImagePath': ''
        }

        # Prepare a large file
        large_image_path = os.path.join(self.uploads_dir, 'large_test_image.jpg')
        with open(large_image_path, 'wb') as f:
            f.write(os.urandom(6 * 1024 * 1024))  # 6MB random content

        with open(large_image_path, 'rb') as large_file:
            files = {
                'imgProduct': ('large_test_image.jpg', large_file, 'image/jpeg')
            }

            # Send the POST request
            response = self.session.post(f'{self.create_product_url}?shelfID={self.shelf_id}', data=data, files=files, verify=False)
            print("Response Status Code:", response.status_code)
            print("Response Headers:", response.headers)
            print("Response Text:", response.text)

        # Check the response status code
        self.assertEqual(response.status_code, 200, "Failed with large file size, received status code: " + str(response.status_code))

        # Check the response content for error message
        self.assertIn('Error: File size is larger than the allowed limit', response.text)

        # Clean up the large test file
        os.remove(large_image_path)

if __name__ == '__main__':
    unittest.main()
