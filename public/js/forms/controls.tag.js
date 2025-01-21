/**
 *
 * TagControls
 *
 * Interface.Forms.Controls.Tags page content scripts. Initialized from scripts.js file.
 *
 *
 */

class TagControls {
  constructor() {
    // Initialization of the page plugins
    if (typeof Tagify === 'undefined') {
      console.log('Tagify is undefined!');
      return;
    }

    this._initTagsBasic();
    this._initTagsTextArea();
    this._initTagsCustomLook();
    this._initTagsAdvanced();
    this._initTagsOutside();
    this._initUsersListTags();
    this._initTagsWithProps();
    this._initTagsReadonly();
    this._initTagsReadonlyMix();
    this._initTagsSelectMode();
    this._initTagsTopLabel();
    this._initTagsFilled();
    this._initTagsFloatingLabel();
  }

  // Basic tags
  _initTagsBasic() {
    if (document.querySelector('#tagsBasic')) {
      new Tagify(document.querySelector('#tagsBasic'));
    }
  }

  // Tags that are outside of input
  _initTagsOutside() {
    if (document.querySelector('#tagsOutside')) {
      new Tagify(document.querySelector('#tagsOutside'), {
        whitelist: [
          'Anpan',
          'Breadstick',
          'Biscotti',
          'Cholermüs',
          'Dorayaki',
          'Fougasse',
          'Kifli',
          'Lefse',
          'Melonpan',
          'Naan',
          'Qistibi',
          'Panbrioche',
          'Rewena',
          'Shirmal',
          'Tunnbröd',
          'Vánočka',
          'Zopf',
        ],
        dropdown: {
          position: 'input',
          enabled: 0, // always opens dropdown when input gets focus
        },
      });
    }
  }

  // Tags with text area
  _initTagsTextArea() {
    if (document.querySelector('#tagsTextArea')) {
      new Tagify(document.querySelector('#tagsTextArea'), {
        enforceWhitelist: true,
        delimiters: null,
        whitelist: [
          'Anpan',
          'Breadstick',
          'Biscotti',
          'Cholermüs',
          'Dorayaki',
          'Fougasse',
          'Kifli',
          'Lefse',
          'Melonpan',
          'Naan',
          'Qistibi',
          'Panbrioche',
          'Rewena',
          'Shirmal',
          'Tunnbröd',
          'Vánočka',
          'Zopf',
        ],
        callbacks: {
          add: console.log, // callback when adding a tag
          remove: console.log, // callback when removing a tag
        },
      });
    }
  }

  // Readonly tags
  _initTagsReadonly() {
    if (document.querySelector('#tagsReadonly')) {
      new Tagify(document.querySelector('#tagsReadonly'));
    }
  }

  // Readonly and standard tags
  _initTagsReadonlyMix() {
    if (document.querySelector('#tagsReadonlyMix')) {
      new Tagify(document.querySelector('#tagsReadonlyMix'));
    }
  }

  // Top label tags
  _initTagsTopLabel() {
    if (document.querySelector('#tagsTopLabel')) {
      new Tagify(document.querySelector('#tagsTopLabel'));
    }
  }

  // Filled tags
  _initTagsFilled() {
    if (document.querySelector('#tagsFilled')) {
      new Tagify(document.querySelector('#tagsFilled'));
    }
  }

  // Floating label tags
  _initTagsFloatingLabel() {
    if (document.querySelector('#tagsFloatingLabel')) {
      new Tagify(document.querySelector('#tagsFloatingLabel'));
    }
  }

  // Select mode
  _initTagsSelectMode() {
    if (document.querySelector('#tagsSelectMode')) {
      var tagifySelect = new Tagify(document.querySelector('#tagsSelectMode'), {
        mode: 'select',
        whitelist: ['first option', 'second option', 'third option'],
        blacklist: ['foo', 'bar'],
        keepInvalidTags: true,
        dropdown: {},
      });
    }
  }

  // Countries with flags
  _initTagsWithProps() {
    if (document.querySelector('#tagsWithProps')) {
      var tagifyProps = new Tagify(document.querySelector('#tagsWithProps'), {
        delimiters: null,
        templates: {
          tag: function (tagData) {
            try {
              return `<tag title='${tagData.value}' contenteditable='false' spellcheck="false" class='tagify__tag ${
                tagData.class ? tagData.class : ''
              }' ${this.getAttributes(tagData)}>
                                  <x title='remove tag' class='tagify__tag__removeBtn'></x>
                                  <div>
                                      ${
                                        tagData.code
                                          ? `<img onerror="this.style.visibility = 'hidden'" src='https://lipis.github.io/flag-icon-css/flags/4x3/${tagData.code.toLowerCase()}.svg' />`
                                          : ''
                                      }
                                      <span class='tagify__tag-text'>${tagData.value}</span>
                                  </div>
                              </tag>`;
            } catch (err) {}
          },

          dropdownItem: function (tagData) {
            try {
              return `<div class='tagify__dropdown__item ${tagData.class ? tagData.class : ''}' tagifySuggestionIdx="${tagData.tagifySuggestionIdx}">
                                      <img onerror="this.style.visibility = 'hidden'"
                                           src='https://lipis.github.io/flag-icon-css/flags/4x3/${tagData.code.toLowerCase()}.svg' />
                                      <span>${tagData.value}</span>
                                  </div>`;
            } catch (err) {}
          },
        },
        enforceWhitelist: true,
        whitelist: [
          {value: 'Afghanistan', code: 'AF'},
          {value: 'Åland Islands', code: 'AX'},
          {value: 'Albania', code: 'AL'},
          {value: 'Algeria', code: 'DZ'},
          {value: 'American Samoa', code: 'AS'},
          {value: 'Andorra', code: 'AD'},
          {value: 'Angola', code: 'AO'},
          {value: 'Anguilla', code: 'AI'},
          {value: 'Antarctica', code: 'AQ'},
          {value: 'Antigua and Barbuda', code: 'AG'},
          {value: 'Argentina', code: 'AR'},
          {value: 'Armenia', code: 'AM'},
          {value: 'Aruba', code: 'AW'},
          {value: 'Australia', code: 'AU', searchBy: 'beach, sub-tropical'},
          {value: 'Austria', code: 'AT'},
          {value: 'Azerbaijan', code: 'AZ'},
        ],
        dropdown: {
          enabled: 1, // suggest tags after a single character input
          classname: 'extra-properties', // custom class for the suggestions dropdown
        }, // map tags' values to this property name, so this property will be the actual value and not the printed value on the screen
      });

      tagifyProps.on('click', function (e) {});
      tagifyProps.on('remove', function (e) {});
      tagifyProps.on('add', function (e) {});

      // add the first 2 tags and makes them readonly
      var tagsToAdd = tagifyProps.settings.whitelist.slice(0, 2);
      tagifyProps.addTags(tagsToAdd);
    }
  }

  // Custom email tags
  _initTagsCustomLook() {
    if (document.querySelector('#tagsCustomLook')) {
      // generate random whilist items (for the demo)
      var randomStringsArr = Array.apply(null, Array(100)).map(function () {
        return (
          Array.apply(null, Array(~~(Math.random() * 10 + 3)))
            .map(function () {
              return String.fromCharCode(Math.random() * (123 - 97) + 97);
            })
            .join('') + '@gmail.com'
        );
      });

      var input = document.querySelector('#tagsCustomLook');
      var tagifyEmail = new Tagify(input, {
        pattern: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        whitelist: randomStringsArr,
        callbacks: {
          invalid: onInvalidTag,
        },
        dropdown: {
          position: 'text',
          enabled: 1, // show suggestions dropdown after 1 typed character
        },
      });
      var button = input.nextElementSibling; // "add new tag" action-button
      button.addEventListener('click', onAddButtonClick);
      function onAddButtonClick() {
        tagifyEmail.addEmptyTag();
      }
      function onInvalidTag(e) {}
    }
  }

  // User emails and profile images
  _initUsersListTags() {
    if (document.querySelector('#usersListTags')) {
      function tagTemplate(tagData) {
        return `
                    <tag title="${tagData.email}"
                            contenteditable='false'
                            spellcheck='false'
                            tabIndex="-1"
                            class="tagify__tag ${tagData.class ? tagData.class : ''}"
                            ${this.getAttributes(tagData)}>
                        <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                        <div>
                            <div class='tagify__tag__avatar-wrap'>
                                <img src="${tagData.avatar}" />
                            </div>
                            <span class='tagify__tag-text'>${tagData.name}</span>
                        </div>
                    </tag>`;
      }

      function suggestionItemTemplate(tagData) {
        return `
                    <div ${this.getAttributes(tagData)}
                        class='tagify__dropdown__item ${tagData.class ? tagData.class : ''}'
                        tabindex="0"
                        role="option">
                        ${
                          tagData.avatar
                            ? `<div class='tagify__dropdown__item__avatar-wrap'>
                            <img src="${tagData.avatar}" />
                        </div>`
                            : ''
                        }
                        <strong>${tagData.name}</strong>
                        <span>${tagData.email}</span>
                    </div>`;
      }

      var tagifyUserList = new Tagify(document.querySelector('#usersListTags'), {
        enforceWhitelist: true,
        skipInvalid: true, // do not remporarily add invalid tags
        dropdown: {
          closeOnSelect: false,
          enabled: 0,
          classname: 'users-list',
          searchKeys: ['name', 'email'], // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
          tag: tagTemplate,
          dropdownItem: suggestionItemTemplate,
        },
        whitelist: [
          {
            value: 1,
            name: 'Justinian Hattersley',
            avatar: 'img/profile/profile-1.webp',
            email: 'jhattersley0@ucsd.edu',
          },
          {
            value: 2,
            name: 'Antons Esson',
            avatar: 'img/profile/profile-2.webp',
            email: 'aesson1@ning.com',
          },
          {
            value: 3,
            name: 'Ardeen Batisse',
            avatar: 'img/profile/profile-3.webp',
            email: 'abatisse2@nih.gov',
          },
          {
            value: 4,
            name: 'Graeme Yellowley',
            avatar: 'img/profile/profile-4.webp',
            email: 'gyellowley3@behance.net',
          },
          {
            value: 5,
            name: 'Dido Wilford',
            avatar: 'img/profile/profile-5.webp',
            email: 'dwilford4@jugem.jp',
          },
          {
            value: 6,
            name: 'Celesta Orwin',
            avatar: 'img/profile/profile-6.webp',
            email: 'corwin5@meetup.com',
          },
          {
            value: 7,
            name: 'Sally Main',
            avatar: 'img/profile/profile-7.webp',
            email: 'smain6@techcrunch.com',
          },
          {
            value: 8,
            name: 'Grethel Haysman',
            avatar: 'img/profile/profile-8.webp',
            email: 'ghaysman7@mashable.com',
          },
        ],
      });

      tagifyUserList.on('dropdown:show dropdown:updated', onDropdownShow);
      tagifyUserList.on('dropdown:select', onSelectSuggestion);

      var addAllSuggestionsElm;

      function onDropdownShow(e) {
        var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

        if (tagifyUserList.suggestedListItems.length > 1) {
          addAllSuggestionsElm = getAddAllSuggestionsElm();

          // insert "addAllSuggestionsElm" as the first element in the suggestions list
          dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild);
        }
      }

      function onSelectSuggestion(e) {
        if (e.detail.elm == addAllSuggestionsElm) tagifyUserList.dropdown.selectAll.call(tagifyUserList);
      }

      // create a "add all" custom suggestion element every time the dropdown changes
      function getAddAllSuggestionsElm() {
        // suggestions items should be based on "dropdownItem" template
        return tagifyUserList.parseTemplate('dropdownItem', [
          {
            class: 'addAll',
            name: 'Add all',
            email:
              tagifyUserList.settings.whitelist.reduce(function (remainingSuggestions, item) {
                return tagifyUserList.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1;
              }, 0) + ' Members',
          },
        ]);
      }
    }
  }

  // Advanced tags with a whitelist and events
  _initTagsAdvanced() {
    if (document.querySelector('#tagsAdvanced')) {
      var whitelist = [
        'Anpan',
        'Breadstick',
        'Biscotti',
        'Cholermüs',
        'Dorayaki',
        'Fougasse',
        'Kifli',
        'Lefse',
        'Melonpan',
        'Naan',
        'Qistibi',
        'Panbrioche',
        'Rewena',
        'Shirmal',
        'Tunnbröd',
        'Vánočka',
        'Zopf',
      ];
      var tagifyAdvanced = new Tagify(document.querySelector('#tagsAdvanced'), {
        enforceWhitelist: true,
        dropdown: {
          enabled: 1,
        },
        whitelist: document
          .querySelector('#tagsAdvanced')
          .value.trim()
          .split(/\s*,\s*/), // Array of values. stackoverflow.com/a/43375571/104380
      });

      // "remove all tags" button event listener
      document.querySelector('#removeAllTags').addEventListener('click', tagifyAdvanced.removeAllTags.bind(tagifyAdvanced));

      // Chainable event listeners
      tagifyAdvanced
        .on('add', onAddTag)
        .on('remove', onRemoveTag)
        .on('input', onInput)
        .on('edit', onTagEdit)
        .on('invalid', onInvalidTag)
        .on('click', onTagClick)
        .on('focus', onTagifyFocusBlur)
        .on('blur', onTagifyFocusBlur)
        .on('dropdown:hide dropdown:show', (e) => console.log(e.type))
        .on('dropdown:select', onDropdownSelect);

      var mockAjax = (function mockAjax() {
        var timeout;
        return function (duration) {
          clearTimeout(timeout); // abort last request
          return new Promise(function (resolve, reject) {
            timeout = setTimeout(resolve, duration || 700, whitelist);
          });
        };
      })();

      // tag added callback
      function onAddTag(e) {
        console.log('onAddTag: ', e.detail);
        console.log('original input value: ', document.querySelector('#tagsAdvanced').value);
        tagifyAdvanced.off('add', onAddTag); // exmaple of removing a custom Tagify event
      }

      // tag remvoed callback
      function onRemoveTag(e) {
        console.log('onRemoveTag:', e.detail, 'tagify instance value:', tagifyAdvanced.value);
      }

      // on character(s) added/removed (user is typing/deleting)
      function onInput(e) {
        console.log('onInput: ', e.detail);
        tagifyAdvanced.settings.whitelist.length = 0; // reset current whitelist
        tagifyAdvanced.loading(true).dropdown.hide.call(tagifyAdvanced); // show the loader animation

        // get new whitelist from a delayed mocked request (Promise)
        mockAjax().then(function (result) {
          // replace tagify "whitelist" array values with new values
          // and add back the ones already choses as Tags
          tagifyAdvanced.settings.whitelist.push(...result, ...tagifyAdvanced.value);

          // render the suggestions dropdown.
          tagifyAdvanced.loading(false).dropdown.show.call(tagifyAdvanced, e.detail.value);
        });
      }

      function onTagEdit(e) {}

      function onInvalidTag(e) {}

      function onTagClick(e) {}

      function onTagifyFocusBlur(e) {}

      function onDropdownSelect(e) {}
    }
  }
}
