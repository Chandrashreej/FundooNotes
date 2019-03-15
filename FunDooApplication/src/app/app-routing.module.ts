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
import { NotesComponent } from './notes/notes.component';


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
    path: 'dashboard',
    component: DashboardComponent,
     children: [
     {
        path: "notes",
        component: NotesComponent,
       
      }
     ]
  },
  {
    path: 'reset',
    component: ResetPasswordComponent
  },
  {
    path: 'session',
    component: SessionexpiredComponent
  },
  {
    path: 'notes',
    component: NotesComponent
  },
  

];

@NgModule({
  imports: [RouterModule.forRoot(routes),
    MatButtonModule,
    MatCheckboxModule,

  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
