import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA, MatDialog } from '@angular/material';

@Component({
  selector: 'app-editnotes',
  templateUrl: './editnotes.component.html',
  styleUrls: ['./editnotes.component.scss']
})
export class EditnotesComponent implements OnInit {

  constructor(    public dialogRef: MatDialogRef<EditnotesComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any,
    
    public dialog: MatDialog,) { }

  ngOnInit() {
  }
  editNotes() {

    if (
      this.data.user.notes != null &&
      this.data.user.title != null &&
      this.data.user.title != ""
    ) {
      // let obs = this.notesService.editedNoteData(this.data.user, this.email);
      // obs.subscribe((res: any) => {});
      // this.dialogRef.close();
    }

}
}