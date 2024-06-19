import unittest
import requests
import os

class TestCreateShelf(unittest.TestCase):
    def setUp(self):
        self.base_url = 'http://localhost:8081/smartshelf'  # Adjust the URL to match your environment
        self.create_shelf_url = f'{self.base_url}/shelf_management/controllers/process_shelf_creation.php'
        self.uploads_dir = 'c:/xampp/htdocs/smartshelf/uploads/'

        # Ensure the uploads directory exists
        if not os.path.exists(self.uploads_dir):
            os.makedirs(self.uploads_dir)

        # Create a sample image file for testing
        self.image_path = os.path.join(self.uploads_dir, 'test_image.jpg')
        with open(self.image_path, 'wb') as f:
            f.write(os.urandom(1024))  # 1KB random content

        # Start a session
        self.session = requests.Session()
        self.session.post(f'{self.base_url}/login.php', data={'username': 'test@user.com', 'password': 'testuser'})  # Adjust login details

    def tearDown(self):
        # Clean up uploaded test image
        if os.path.exists(self.image_path):
            os.remove(self.image_path)

    def test_create_shelf(self):
        # Prepare the data
        data = {
            'name': 'Test Shelf',
            'accessEmails': 'test1@example.com, test2@example.com'
        }

        # Prepare the files
        with open(self.image_path, 'rb') as img_file:
            files = {
                'imgShelf': ('default-product.png', img_file, 'image/png')
            }

            # Send the POST request
            response = self.session.post(self.create_shelf_url, data=data, files=files)

        # Check the response content
        self.assertNotIn('Error', response.text)

    def test_invalid_file_format(self):
        # Prepare the data
        data = {
            'name': 'Test Shelf',
            'accessEmails': 'test1@example.com, test2@example.com'
        }

        # Prepare an invalid file format
        invalid_image_path = os.path.join(self.uploads_dir, 'test_image.txt')
        with open(invalid_image_path, 'w') as f:
            f.write('This is a text file, not an image.')

        with open(invalid_image_path, 'rb') as invalid_file:
            files = {
                'imgShelf': ('test_image.txt', invalid_file, 'text/plain')
            }

            # Send the POST request
            response = self.session.post(self.create_shelf_url, data=data, files=files)

        # Check the response status code
        self.assertEqual(response.status_code, 200)

        # Check the response content for error message
        self.assertIn('Error: Invalid file format', response.text)

        # Clean up the invalid test file
        os.remove(invalid_image_path)

if __name__ == '__main__':
    unittest.main()
