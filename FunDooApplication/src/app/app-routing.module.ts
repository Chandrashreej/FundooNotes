import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from './Components/login/login.component';
import { RegisterComponent } from './Components/register/register.component';
import {MatButtonModule, MatCheckboxModule} from '@angular/material';
import 'hammerjs';
const routes: Routes = [
  {
    path: '',
    component: LoginComponent
  },
  {
    path: 'register',
    component: RegisterComponent
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
