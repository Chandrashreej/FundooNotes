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

import { ReminderComponent } from './Components/reminder/reminder.component';
import {MatDatepickerModule} from '@angular/material/datepicker';
import { EditnotesComponent } from './Components/editnotes/editnotes.component';
import { CollaborateComponent } from './Components/collaborate/collaborate.component';

import { ArchiveComponent } from './Components/archive/archive.component';

import { TrashComponent } from './Components/trash/trash.component';
import { LabelComponent } from './Components/label/label.component';

// import {
//   SocialLoginModule,
//   AuthServiceConfig,
//   GoogleLoginProvider,
//   FacebookLoginProvider,
// } from "angular-6-social-login";
import {
	AuthService as social,
	SocialLoginModule,
	AuthServiceConfig,
  AuthService,
  SocialUser
} from "angular-6-social-login";
import { CookieService } from 'ngx-cookie-service';
import { getAuthServiceConfigs } from './socialLogin';
import { AuthService as auth } from "./Services/auth.service";
import { NgxTwitterTimelineModule } from 'ngx-twitter-timeline';
import { SearchfilterPipe } from './Services/dashboardService/searchfilter.pipe';
import { EmptycontentComponent } from './Components/emptycontent/emptycontent.component';
import { LabelednotesComponent } from './Components/labelednotes/labelednotes.component';

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
 
    ReminderComponent,
    EditnotesComponent,
    CollaborateComponent,

    ArchiveComponent,
    LabelComponent,
    TrashComponent,
    EmptycontentComponent,
    SearchfilterPipe,
    LabelednotesComponent,

  
    
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
  providers: [RegisterService,ServiceUrlService,LoginService,CookieService, AuthService, SocialLoginModule,SocialUser, 
    NgxTwitterTimelineModule,
		auth,
		{
			provide: AuthServiceConfig,
			useFactory: getAuthServiceConfigs
		}],
  bootstrap: [AppComponent],
  entryComponents:[EditnotesComponent, LabelComponent]
})
export class AppModule { }
