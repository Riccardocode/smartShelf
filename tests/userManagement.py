import unittest
import requests


class TestRegistration(unittest.TestCase):
    def setUp(self):
        #host was set to ricode.it before, but since there were permission issues and not much time, the tests have been done locally
        host = "http://localhost:8081/smartshelf"
        self.register_url = host + "/usermanagement/process_register.php"
        self.login_url = host +"/usermanagement/process_login.php"
        self.logout_url = host +"/usermanagement/logout.php"
        self.update_url = host +"/usermanagement/process_edit_user.php"
        self.delete_url = host +"/usermanagement/deleteUser.php"
        self.protected_page_url = host +"/dashboard.php"  
        self.new_user_email = "john.doe@example.com"
        self.new_user_password = "securepassword"
        self.new_user_firstname = "John"
        self.new_user_lastname = "Doe"
        self.session = requests.Session()

    def test_registration_with_valid_input(self):
        payload = {
            'firstname': 'John',
            'lastname': 'Doe',
            'email': 'john.doe@example.com',
            'password': 'securepassword'
        }
        with open('default-product.png', 'rb') as img:
            files = {
                'imgProfile': ('profile.jpg', img, 'image/png')
            }
            response = requests.post(self.register_url, data=payload, files=files)
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
            response = requests.post(self.register_url, data=payload, files=files)
            self.assertEqual(response.status_code, 200)  # Assuming redirect on success
    def test_login_with_valid_credentials(self):
        # First, register the user
        self.test_registration_with_valid_input()

        # Now, try to login with the new user's credentials
        payload = {
            'email': self.new_user_email,
            'password': self.new_user_password
        }
        response = self.session.post(self.login_url, data=payload)
        print("Login Response URL:", response.url)
        self.assertEqual(response.status_code, 200)
        self.assertNotIn('invalidcredentials', response.url)

    def test_login_with_invalid_credentials(self):
        # Attempt to login with incorrect credentials
        payload = {
            'email': 'wrong.email@example.com',
            'password': 'wrongpassword'
        }
        response = self.session.post(self.login_url, data=payload)
        print("Login with Invalid Credentials Response URL:", response.url)
        self.assertEqual(response.status_code, 200)
        self.assertIn('invalidcredentials', response.url)
    
    def test_logout(self):
        # First, register the user
        self.test_registration_with_valid_input()

        # Login with the new user's credentials
        payload = {
            'email': self.new_user_email,
            'password': self.new_user_password
        }
        response = self.session.post(self.login_url, data=payload)
        self.assertEqual(response.status_code, 200)
        self.assertNotIn('invalidcredentials', response.url)

        # Logout the user
        response = self.session.get(self.logout_url)
        print("Logout Response URL:", response.url)
        self.assertEqual(response.status_code, 200)

    
        
        # Verify that the user is logged out by attempting to access a protected page
        response = self.session.get(self.protected_page_url, allow_redirects=False)
        print("Protected Page Access After Logout Response URL:", response.url)
        self.assertEqual(response.status_code, 302)  # Expecting a redirect
        self.assertIn('login.php', response.headers['Location'])
    
    
   
    
    def get_user_id_from_dashboard(self):
        response = self.session.get(self.protected_page_url)
        soup = BeautifulSoup(response.text, 'html.parser')
        user_id_input = soup.find('input', {'id': 'user_id'})
        if user_id_input:
            return user_id_input['value']
        return None

if __name__ == '__main__':
    unittest.main()
