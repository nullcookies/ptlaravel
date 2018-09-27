import { OsmallPosPage } from './app.po';

describe('osmall-pos App', () => {
  let page: OsmallPosPage;

  beforeEach(() => {
    page = new OsmallPosPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
