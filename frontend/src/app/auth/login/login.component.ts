import { Component } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';

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
      });
  }
}
