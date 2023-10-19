import {Component,OnInit,} from '@angular/core';
import {AuthService} from 'src/app/services/auth.service';
import {RoleRPGuard} from '../../shared/Guards/RoleRPGuard';
import {ActivatedRouteSnapshot, RouterStateSnapshot} from '@angular/router';
import {RoleAttacheGuards} from "../../shared/Guards/RoleAttacheGuards";


@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
})
export class DashboardComponent implements OnInit {
  showLink: boolean = false;
  showLinkforAttache: boolean = false;
  user: any;
  menuOuvert: boolean = false;

  constructor(private authService: AuthService,
              private roleRPGuard: RoleRPGuard,
              private roleAttacheGuards: RoleAttacheGuards,) {
  }


  emptyRouteSnapshot: ActivatedRouteSnapshot = {} as ActivatedRouteSnapshot;
  emptyRouterStateSnapshot: RouterStateSnapshot = {} as RouterStateSnapshot;
  ngOnInit() {
    this.authService.getCurrentUser().subscribe((response: any) => {
      this.user = response.data;
    });
    this.showLink = this.roleRPGuard
      .canActivate(this.emptyRouteSnapshot, this.emptyRouterStateSnapshot)
      .subscribe((response: any) => {
        // console.log(response);
        this.showLink = response;
      });
    this.showLinkforAttache = this.roleAttacheGuards.canActivate(this.emptyRouteSnapshot, this.emptyRouterStateSnapshot).subscribe((response: any) => {
      this.showLinkforAttache = response;
      console.log(this.showLinkforAttache)
    });
  }
  deconnecter() {
    this.authService.logout();
  }
  toggleOptons() {
    this.menuOuvert = !this.menuOuvert;
  }
}
