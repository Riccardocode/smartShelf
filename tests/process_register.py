import unittest
import requests

class TestRegistration(unittest.TestCase):
    def setUp(self):
        self.base_url = "http://localhost/usermanagement/process_register.php"

    def test_registration_with_valid_input(self):
        payload = {
            'firstname': 'John',
            'lastname': 'Doe',
            'email': 'john.doe@example.com',
            'password': 'securepassword'
        }
        files = {
            'imgProfile': ('profile.jpg', open('/path/to/profile.jpg', 'rb'), 'image/jpeg')
        }
        response = requests.post(self.base_url, data=payload, files=files)
        self.assertEqual(response.status_code, 302)  # Assuming redirect on success

    def test_registration_with_special_characters(self):
        payload = {
            'firstname': 'John<>?',
            'lastname': 'Doe<>?',
            'email': 'john.doe@example.com<>?',
            'password': 'securepassword'
        }
        response = requests.post(self.base_url, data=payload)
        self.assertIn('specialcharacters', response.headers['Location'])

if __name__ == '__main__':
    unittest.main()
