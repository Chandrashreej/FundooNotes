import { TestBed } from '@angular/core/testing';

import { LabelidService } from './labelid.service';

describe('LabelidService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: LabelidService = TestBed.get(LabelidService);
    expect(service).toBeTruthy();
  });
});
