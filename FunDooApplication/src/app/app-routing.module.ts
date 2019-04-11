import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './Components/login/login.component';
import { RegisterComponent } from './Components/register/register.component';
import {MatButtonModule, MatCheckboxModule} from '@angular/material';
import 'hammerjs';
import { ForgotPasswordComponent } from './Components/forgot-password/forgot-password.component';
import { DashboardComponent } from './Components/dashboard/dashboard.component';
import { ResetPasswordComponent } from './Components/reset-password/reset-password.component';
import { SessionexpiredComponent } from './Components/sessionexpired/sessionexpired.component';
import { NotesComponent } from './Components/notes/notes.component';
import { ReminderComponent } from './Components/reminder/reminder.component';
import { ArchiveComponent } from './Components/archive/archive.component';
import { TrashComponent } from './Components/trash/trash.component';
import { LabelComponent } from './Components/label/label.component';
import { EmptycontentComponent } from './Components/emptycontent/emptycontent.component';



const routes: Routes = [
  {
    path: '',
    component: LoginComponent
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: 'register',
    component: RegisterComponent
  },
  {
    path: 'forgotPassword',
    component: ForgotPasswordComponent
  }
  ,
  {
    path: 'home',
    component: DashboardComponent,
    children: [
     {
        path: "",
        component: NotesComponent,      
      },
      {
           path: "notes",
           component: NotesComponent,      
      },
      {
        path: "reminder",
        component: ReminderComponent,      
      },
      {
        path: 'archive',
        component: ArchiveComponent,      
      },
      {
        path: 'bin',
        component: TrashComponent,      
      },
      {
        path: 'emptycontent',
        component: EmptycontentComponent,      
      },
      
     ]
  },
  {
    path: 'reset',
    component: ResetPasswordComponent
  },
  {
    path: 'session',
    component: SessionexpiredComponent
  }

  

];

@NgModule({
  imports: [RouterModule.forRoot(routes),
    MatButtonModule,
    MatCheckboxModule,

  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
