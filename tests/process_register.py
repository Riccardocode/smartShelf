import unittest
import requests

class TestRegistration(unittest.TestCase):
    def setUp(self):
        self.base_url = "http://ricode.it/smartshelf/usermanagement/process_register.php"

    def test_registration_with_valid_input(self):
        payload = {
            'firstname': 'John',
            'lastname': 'Doe',
            'email': 'john.doe@example.com',
            'password': 'securepassword'
        }
        with open('default-product.png', 'rb') as img:
            files = {
                'imgProfile': ('profile.jpg', img, 'image/jpeg')
            }
            response = requests.post(self.base_url, data=payload, files=files)
            self.assertEqual(response.status_code, 200)  # Assuming redirect on success

    def test_registration_with_special_characters(self):
        payload = {
            'firstname': 'John<>?',
            'lastname': 'Doe<>?',
            'email': 'john.doe@example.com<>?',
            'password': 'securepassword'
        }
        with open('default-product.png', 'rb') as img:
            files = {
                'imgProfile': ('profile.jpg', img, 'image/jpeg')
            }
            response = requests.post(self.base_url, data=payload, files=files)
            self.assertEqual(response.status_code, 200)  # Assuming redirect on success


if __name__ == '__main__':
    unittest.main()
