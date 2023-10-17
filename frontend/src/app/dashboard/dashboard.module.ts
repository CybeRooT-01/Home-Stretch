import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardComponent } from './dashboard/dashboard.component';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from '../shared/Guards/AuthGuards';
import { InscriptionComponent } from './inscription/inscription.component';
import { RoleRPGuard } from '../shared/Guards/RoleRPGuard';
import { SessionCoursComponent } from './session-cours/session-cours.component';
import { FullCalendarModule } from '@fullcalendar/angular';
import { PlanificationComponent } from './planification/planification.component';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { MatIconModule } from '@angular/material/icon';
import {MatCheckboxModule} from '@angular/material/checkbox';
import { MatSelectModule } from '@angular/material/select';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {NgxMatTimepickerModule} from 'ngx-mat-timepicker';
import { CoursComponent } from './cours/cours.component';
import {MatTableModule} from '@angular/material/table';
import {RoleProfRPEtudiantGuards} from "../shared/Guards/RoleProfRPEtudiantGuards";
import { DemandeANnulationComponent } from './demande-annulation/demande-annulation.component';
import { MessageComponent } from './message/message.component';
import { AbsencesComponent } from './absences/absences.component';
import {RoleAttacheGuards} from "../shared/Guards/RoleAttacheGuards";
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
        canActivate: [RoleProfRPEtudiantGuards]
      },
      {
        path: 'planification',
        component: PlanificationComponent,
        canActivate: [RoleRPGuard],
      },
      {
        path:'demandeAnnulation',
        component:DemandeANnulationComponent,
        canActivate:[RoleRPGuard]
      },
      {
        path: 'cours',
        component: CoursComponent,
        canActivate: [RoleRPGuard],
      },
      {
        path: 'absences',
        component: AbsencesComponent,
        canActivate: [RoleAttacheGuards],
      }
    ],
  },
];

@NgModule({
  declarations: [
    DashboardComponent,
    InscriptionComponent,
    SessionCoursComponent,
    PlanificationComponent,
    CoursComponent,
    DemandeANnulationComponent,
    MessageComponent,
    AbsencesComponent,
  ],
  imports: [
    MatTableModule,
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
    FormsModule,
    NgxMatTimepickerModule,
    MatCheckboxModule
  ],
  providers: [],
})
export class DashboardModule {}
