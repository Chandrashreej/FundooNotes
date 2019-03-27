
import { NgModule , CUSTOM_ELEMENTS_SCHEMA} from '@angular/core';
import { CommonModule } from '@angular/common';
import {

MatButtonModule, MatCardModule, MatDialogModule, MatInputModule, MatTableModule,

 MatMenuModule, MatIconModule, MatProgressSpinnerModule, MatFormFieldModule, MatButtonToggleModule, MatDividerModule, MatListModule

} from '@angular/material';
import {MatToolbarModule} from '@angular/material/toolbar';
import {MatSidenavModule} from '@angular/material/sidenav';
import {MatGridListModule} from '@angular/material/grid-list';
import {MatTooltipModule} from '@angular/material/tooltip';
import {MatChipsModule} from '@angular/material/chips';
import {MatSnackBarModule} from '@angular/material/snack-bar';

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
MatDividerModule,
MatListModule,
MatGridListModule,
MatTooltipModule,
MatChipsModule,
MatSnackBarModule
],
schemas: [
    CUSTOM_ELEMENTS_SCHEMA
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
MatDividerModule,
MatListModule,
MatGridListModule,
MatTooltipModule,
MatChipsModule,
MatSnackBarModule
],
})

export class MaterialModule {
}
