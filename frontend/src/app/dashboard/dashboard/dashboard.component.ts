import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { RoleRPGuard } from '../../shared/Guards/roleRPGuard';
import { ActivatedRouteSnapshot, RouterStateSnapshot} from '@angular/router';
@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
})
export class DashboardComponent implements OnInit {
  showLink: any;
  user: any;
  menuOuvert: boolean = false;
  constructor(private authService: AuthService, private roleRPGuard: RoleRPGuard) {}
  emptyRouteSnapshot: ActivatedRouteSnapshot = {} as ActivatedRouteSnapshot;
  emptyRouterStateSnapshot: RouterStateSnapshot = {} as RouterStateSnapshot;
  ngOnInit() {
    this.showLink = this.roleRPGuard
      .canActivate(this.emptyRouteSnapshot, this.emptyRouterStateSnapshot)
      .subscribe((response: any) => {
        // console.log(response);
        this.showLink = response;
      });
    this.authService.getCurrentUser().subscribe((response: any) => {
      this.user = response.data;
      console.log(this.user);
    });
  }
  deconnecter() {
    this.authService.logout();
  }
  toggleOptons() {
    this.menuOuvert = !this.menuOuvert;

  }
}
