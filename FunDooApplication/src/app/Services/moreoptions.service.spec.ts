import { TestBed } from '@angular/core/testing';

import { MoreoptionsService } from './moreoptions.service';

describe('MoreoptionsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: MoreoptionsService = TestBed.get(MoreoptionsService);
    expect(service).toBeTruthy();
  });
});
