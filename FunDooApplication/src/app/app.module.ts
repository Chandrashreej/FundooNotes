import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FlexLayoutModule } from "@angular/flex-layout";

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './Components/login/login.component';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {NoopAnimationsModule} from '@angular/platform-browser/animations';
import {MatButtonModule, MatCheckboxModule, MatNativeDateModule} from '@angular/material';
import {MatFormFieldModule} from '@angular/material/form-field';
import { MatIconModule } from '@angular/material';
import {MatCardModule} from '@angular/material/card';
import {  MatInputModule } from '@angular/material';
import { RegisterComponent } from './Components/register/register.component';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';

import { RegisterService } from './Services/registerService/ServiceRegister';

import { LoginService } from './Services/loginService/ServiceLogin';
import { ServiceUrlService } from './ServiceUrl/service-url.service';
import { ForgotPasswordComponent } from './Components/forgot-password/forgot-password.component';
import { DashboardComponent } from './Components/dashboard/dashboard.component';
import { ResetPasswordComponent } from './Components/reset-password/reset-password.component';
import { SessionexpiredComponent } from './Components/sessionexpired/sessionexpired.component';
import { MaterialModule } from './Material.Module';
import { NotesComponent } from './Components/notes/notes.component';
import { AddnotesComponent } from './Components/addnotes/addnotes.component';
import { ReminderComponent } from './Components/reminder/reminder.component';
import {MatDatepickerModule} from '@angular/material/datepicker';
import { EditnotesComponent } from './Components/editnotes/editnotes.component';




@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    ForgotPasswordComponent,
    DashboardComponent,
    ResetPasswordComponent,
    SessionexpiredComponent,
    NotesComponent,
    AddnotesComponent,
    ReminderComponent,
    EditnotesComponent
  
    
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    NoopAnimationsModule,
    MatButtonModule,
    MatCheckboxModule,
    MatFormFieldModule,
    MatIconModule,
    MatCardModule,
    MatInputModule,
    FlexLayoutModule,
    ReactiveFormsModule,
    HttpClientModule,
    MaterialModule,
    FormsModule,
    MatDatepickerModule,

    MatNativeDateModule 
    
  ],
  exports: [
    MatButtonModule,
    MatCheckboxModule,
    FormsModule,
    MatDatepickerModule,
    MatNativeDateModule 
  ],
  providers: [RegisterService,ServiceUrlService,LoginService],
  bootstrap: [AppComponent]
})
export class AppModule { }
