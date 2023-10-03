import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { AuthGuard } from '../../shared/AuthGuards';
import { RoleGuard } from '../../shared/roleGuard';
import { ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable, of } from 'rxjs';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
})
export class DashboardComponent implements OnInit {
  showLink: any;
  constructor(private authService: AuthService, private roleGuard: RoleGuard) {}
  emptyRouteSnapshot: ActivatedRouteSnapshot = {} as ActivatedRouteSnapshot;
  emptyRouterStateSnapshot: RouterStateSnapshot = {} as RouterStateSnapshot;
  ngOnInit() {
    this.showLink = this.roleGuard
      .canActivate(this.emptyRouteSnapshot, this.emptyRouterStateSnapshot)
      .subscribe((response: any) => {
        console.log(response);
        this.showLink = response;
      });
  }
  deconnecter() {
    this.authService.logout();
  }
}
