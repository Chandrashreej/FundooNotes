import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './Components/login/login.component';
import { RegisterComponent } from './Components/register/register.component';
import {MatButtonModule, MatCheckboxModule} from '@angular/material';
import 'hammerjs';
import { ForgotPasswordComponent } from './Components/forgot-password/forgot-password.component';
import { DashboardComponent } from './Components/dashboard/dashboard.component';
import { ResetPasswordComponent } from './Components/reset-password/reset-password.component';
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
    component: DashboardComponent
  },
  {
    path: 'reset',
    component: ResetPasswordComponent
  }
  

];

@NgModule({
  imports: [RouterModule.forRoot(routes),
    MatButtonModule,
    MatCheckboxModule
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
