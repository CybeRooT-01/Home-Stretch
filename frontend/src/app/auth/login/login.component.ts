import { Component } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import notification from 'sweetalert2';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  login: string = '';
  password: string = '';
  constructor(private authService: AuthService) {}

  loginUser() {
    console.log(this.login, this.password);
    this.authService
      .login(this.login, this.password)
      .subscribe((response: any) => {
        console.log(response);
      },
      (error: any) => {
        notification.fire({
          title: 'Erreur',
          icon: 'error',
          text: 'Login ou mot de passe incorrect',
        });
      }
      );
  }
}
