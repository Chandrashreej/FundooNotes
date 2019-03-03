import { NgModule } from '@angular/core';
import { LoginComponent } from './login/login.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import { Routes, RouterModule } from '@angular/router';
import {MatButtonModule, MatCheckboxModule} from '@angular/material';

const routes: Routes = [
  {
    path: 'login',
    component: LoginComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes),
    BrowserAnimationsModule,
    MatButtonModule, 
    MatCheckboxModule],
  exports: [RouterModule]
})
export class AppRoutingModule { }
