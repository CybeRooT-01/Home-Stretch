import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, switchMap, tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private authToken: string | null = null;

  constructor(private http: HttpClient, private router: Router) {}

  login(login: string, password: string) {
    return this.http
      .post('http://127.0.0.1:8000/api/login', { login, password })
      .pipe(
        tap((response: any) => {
          this.setToken(response.token);
          this.router.navigate(['']);
          console.log(response);
        }),
        catchError((error) => {
          console.log(error);
          throw error;
        })
      );
  }

  setToken(token: string) {
    this.authToken = token;
    return localStorage.setItem('token', token);
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }

  isLoggedIn(): boolean {
    return !!this.authToken;
  }

  logout() {
    this.http
      .post('http://127.0.0.1:8000/api/logout', {})
      .pipe(
        switchMap(() => {
          console.log('Déconnexion côté serveur effectuée avec succès !');
          localStorage.removeItem('token');
          this.router.navigate(['/login']);
          return [];
        }),
        catchError((error) => {
          console.log('Erreur lors de la déconnexion côté serveur :', error);
          return [];
        })
      )
      .subscribe(() => {
        this.router.navigate(['/login']);
      });
  }
  getCurrentUser() {
    return this.http.get('http://127.0.0.1:8000/api/user');
  }
}
