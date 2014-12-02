'use strict';

/* http://docs.angularjs.org/guide/dev_guide.e2e-testing */

describe('Bookmark App', function() {

  it('should redirect app.html to app.html#/categories', function() {
    browser.get('app.html');
    browser.getLocationAbsUrl().then(function(url) {
        expect(url.split('#')[1]).toBe('/categories');
    });
  });


  describe('Category list view', function() {

    beforeEach(function() {
      browser.get('app.html#/categories');
    });


    it('should filter the category list as a user types into the search box', function() {

      var categoryList = element.all(by.repeater('dt in datas'));
      var query = element(by.model('query'));

      expect(categoryList.count()).toBe(118);

      query.sendKeys('book');
      expect(categoryList.count()).toBe(6);

      query.clear();
      query.sendKeys('angularjs');
      expect(categoryList.count()).toBe(1);
    });


    it('should be possible to control category order via click to header of table', function() {

      var catNameColumn = element.all(by.repeater('dt in datas').column('dt.name'));
      var query = element(by.model('query'));

      function getNames() {
        return catNameColumn.map(function(elm) {
          return elm.getText();
        });
      }

      query.sendKeys('joom'); //let's narrow the dataset to make the test assertions shorter

      expect(getNames()).toEqual([
        "joomla",
        "joomla template",
      ]);

      element(by.css('#categoryname')).click();

      expect(getNames()).toEqual([
        "joomla template",
        "joomla"
      ]);
    });


    it('should render category specific links', function() {
      var query = element(by.model('query'));
      query.sendKeys('joom');
      element.all(by.css('.categorylink')).first().click();
      browser.getLocationAbsUrl().then(function(url) {
        expect(url.split('#')[1]).toBe('/categories/46');
      });
    });
  });


  describe('Category detail view', function() {

    beforeEach(function() {
      browser.get('app.html#/categories/46');
    });


    it('should display joomla category page', function() {
      expect(element(by.binding('datas.name')).getText()).toBe('joomla');
    });


    it('should render bookmark specific links', function() {
		element.all(by.css('.bookmarklink')).first().click();
		browser.getLocationAbsUrl().then(function(url) {
        expect(url.split('#')[1]).toBe('/bookmarks/377');
      });
    });

    
  });
});
