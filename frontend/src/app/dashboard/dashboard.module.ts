import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardComponent } from './dashboard/dashboard.component';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from '../shared/Guards/AuthGuards';
import { InscriptionComponent } from './inscription/inscription.component';
import { RoleRPGuard } from '../shared/Guards/roleRPGuard';
import { SessionCoursComponent } from './session-cours/session-cours.component';
import { FullCalendarModule } from '@fullcalendar/angular';
import { PlanificationComponent } from './planification/planification.component';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { MatIconModule } from '@angular/material/icon';
import { MatSelectModule } from '@angular/material/select';
import { ReactiveFormsModule } from '@angular/forms';

const authRoutes: Routes = [
  {
    path: '',
    component: DashboardComponent,
    canActivate: [AuthGuard],
    children: [
      {
        path: 'inscription',
        component: InscriptionComponent,
        canActivate: [RoleRPGuard],
      },
      {
        path: 'sessioncours',
        component: SessionCoursComponent,
      },
      {
        path: 'planification',
        component: PlanificationComponent,
      },
    ],
  },
];

@NgModule({
  declarations: [
    DashboardComponent,
    InscriptionComponent,
    SessionCoursComponent,
    PlanificationComponent,
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(authRoutes),
    FullCalendarModule,
    MatFormFieldModule,
    MatInputModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatIconModule,
    MatSelectModule,
    ReactiveFormsModule,
  ],
  providers: [],
})
export class DashboardModule {}
