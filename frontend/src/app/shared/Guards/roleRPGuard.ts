import { Injectable } from '@angular/core';
import {
  CanActivate,
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
  UrlTree,
  Router,
} from '@angular/router';
import { Observable, Subscribable, of } from 'rxjs';
import { AuthService } from '../../services/auth.service';
import { tap, map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class RoleRPGuard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}
  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): any {
    const allowedRoles = ['RP'];
    return this.authService.getCurrentUser().pipe(
      tap((response: any) => {
        // console.log(response);
      }),
      map((response: any) => {
        const userRoles = response.data.role;
        // console.log(userRoles);
        const hasPermission = allowedRoles.some((role) =>
          userRoles.includes(role)
        );
        if (!hasPermission && state.url === '/inscription') {
          this.router.navigate(['/404']); // Assurez-vous que '/404' correspond à votre route de la page 404
        }

        return hasPermission;
      })
    );
  }
}
