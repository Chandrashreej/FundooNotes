
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {

MatButtonModule, MatCardModule, MatDialogModule, MatInputModule, MatTableModule,

 MatMenuModule, MatIconModule, MatProgressSpinnerModule, MatFormFieldModule, MatButtonToggleModule, MatDividerModule

} from '@angular/material';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatSidenavModule} from '@angular/material/sidenav';

@NgModule({
declarations: [],
imports: [
CommonModule,
MatToolbarModule,
MatButtonModule,
MatCardModule,
MatInputModule,
MatDialogModule,
MatTableModule,
MatMenuModule,
MatIconModule,
MatProgressSpinnerModule,
MatFormFieldModule,
MatSidenavModule,
MatButtonToggleModule,
MatDividerModule
],
exports: [
CommonModule,
MatToolbarModule,
MatButtonModule,
MatCardModule,
MatInputModule,
MatDialogModule,
MatTableModule,
MatMenuModule,
MatIconModule,
MatProgressSpinnerModule,
MatFormFieldModule,
MatSidenavModule,
MatButtonToggleModule,
MatDividerModule
],
})

export class MaterialModule {
}
