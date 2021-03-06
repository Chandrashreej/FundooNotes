import { Pipe, PipeTransform } from '@angular/core';
import { NotesModel } from 'src/app/Models/Notes.model';

@Pipe({
  name: 'searchfilter',
  pure: false
})
export class SearchfilterPipe implements PipeTransform {
  num;
  transform(notes: NotesModel[], serchingTerm?: string): NotesModel[] {
    debugger;
    // console.log("hiiiii",notes);
    if (!notes || !serchingTerm) {
      return notes;
    }
    return notes.filter(notes =>
      notes.title.indexOf(serchingTerm)!==-1 || notes.takeANote.indexOf(serchingTerm)!==-1 );

  }

}
