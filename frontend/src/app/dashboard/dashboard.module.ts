import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardComponent } from './dashboard/dashboard.component';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from '../shared/AuthGuards';
import { InscriptionComponent } from './inscription/inscription.component';
import { RoleGuard } from '../shared/roleGuard';
const authRoutes: Routes = [
  {
    path: '',
    component: DashboardComponent,
    canActivate: [AuthGuard],
    children: [
      {
        path: 'inscription',
        component: InscriptionComponent,
        canActivate: [RoleGuard],
      },
    ],
  },
];

@NgModule({
  declarations: [DashboardComponent, InscriptionComponent],
  imports: [CommonModule, RouterModule.forChild(authRoutes)],
  providers: [],
})
export class DashboardModule {}
