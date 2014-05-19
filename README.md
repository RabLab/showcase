# Showcase Plugin

A robust showcase platform plugin for October CMS, can be used to show products, services or until like a photos gallery. Created under RainLab Blog plugin.

## Editing items

The plugin uses the markdown markup for the items. You can use any Markdown syntax and some special tags for embedding images. To embed an image use the image placeholder:

    ![1](image)

The number in the first part is the placeholder index. If you use multiple images in a item you should use an unique index for each image:

    ![1](image)

    ![2](image)
    
You can also add classes or ids to images by using the [markdown extra](http://michelf.ca/projects/php-markdown/extra/) syntax:

    ![1](image){#id .class}

## Implementing front-end pages

The plugin provides several components for building the item list page (archive), category page, item details page and category list for the sidebar.

### Item list page

Use the `showcaseItems` component to display a list of latest showcase items on a page. The component has the following properties:

* **itemsPerPage** - how many items to display on a single page (the pagination is supported automatically). The default value is 10.
* **categoryPage** - path to the category page. The default value is **showcase/category** - it matches the pages/showcase/category.htm file in the theme directory. This property is used in the default component partial for creating links to the showcase categories.
* **itemPage** - path to the item details page. The default value is **showcase/item** - it matches the pages/showcase/item.htm file in the theme directory. This property is used in the default component partial for creating links to the showcase items.
* **noItemsMessage** - message to display in the empty item list.

The showcaseItems component injects the following variables to the page where it's used:

* **items** - a list of showcase items loaded from the database.
* **categoryPage** - contains the value of the `categoryPage` component's property. 
* **itemPage** - contains the value of the `itemPage` component's property. 
* **noItemsMessage** - contains the value of the `noItemsMessage` component's property. 

The component supports pagination and reads the current page index from the `:page` URL parameter. The next example shows the basic component usage on the showcase home page:

    title = "Showcase"
    url = "/showcase/:page?"

    [showcaseItems]
    itemsPerPage = "5"
    ==
    {% component 'showcaseItems' %}

The item list and the pagination are coded in the default component partial `plugins/rablab/showcase/components/items/default.htm`. If the default markup is not suitable for your website, feel free to copy it from the default partial and replace the `{% component %}` call in the example above with the partial contents.

### Category page

Use the `showcaseCategory` component to display a list of a category items. The component has the following properties:

* **itemsPerPage** - how many items to display on a single page (the pagination is supported automatically). The default value is 10.
* **itemPage** - path to the item details page. The default value is **showcase/item** - it matches the pages/showcase/item.htm file in the theme directory. This property is used in the default component partial for creating links to the showcase items.
* **noItemsMessage** - message to display in the empty item list.
* **paramId** - the URL route parameter used for looking up the category by its slug. The default  value is **slug**.

The showcaseItems component injects the following variables to the page where it's used:

* **category** - the showcase category object loaded from the database. If the category is not found, the variable value is **null**.
* **itemPage** - contains the value of the `itemPage` component's property. 
* **items** - a list of showcase items loaded from the database.

The component supports pagination and reads the current page index from the `:page` URL parameter. The next example shows the basic component usage on the showcase category page:

    title = "Showcase Category"
    url = "/showcase/category/:slug/:page?"

    [showcaseCategory category]
    ==
    function onEnd()
    {
        // Optional - set the page title to the category name
        if ($this['category'])
            $this->page->title = $this['category']->name;
    }
    ==
    {% if not category %}
        <h2>Category not found</h2>
    {% else %}
        <h2>{{ category.name }}</h2>

        {% component 'category' %}
    {% endif %}

The category item list and the pagination are coded in the default component partial `plugins/rablab/showcase/components/category/default.htm`.

### Item page

Use the `showcaseItem` component to display a showcase item on a page. The component has the following properties:

* **paramId** - the URL route parameter used for looking up the item by its slug. The default value is **slug**.

The component injects the following variables to the page where it's used:

* **showcaseItem** - the showcase item object loaded from the database. If the item is not found, the variable value is **null**.

The next example shows the basic component usage on the showcase page:

    title = "Showcase Item"
    url = "/showcase/item/:slug"

    [showcaseItem item]
    ==
    <?php
    function onEnd()
    {
        // Optional - set the page title to the item title
        if (isset($this['showcaseItem']))
            $this->page->title = $this['showcaseItem']->title;
    }
    ?>
    ==
    {% if not showcaseItem %}
        <h2>Item not found</h2>
    {% else %}
        <h2>{{ showcaseItem.title }}</h2>

        {% component 'item' %}
    {% endif %}

The item details is coded in the default component partial `plugins/rablab/showcase/components/item/default.htm`.

### Category list

Use the `showcaseCategories` component to display a list of showcase item categories with links. The component has the following properties:

* **categoryPage** - path to the category page. The default value is **showcase/category** - it matches the pages/showcase/category.htm file in the theme directory. This property is used in the default component partial for creating links to the showcase categories.
* **paramId** - the URL route parameter used for looking up the current category by its slug. The default  value is 
**slug**
* **displayEmpty** - determines if empty categories should be displayed. The default value is false.

The component injects the following variables to the page where it's used:

* **categoryPage** - contains the value of the `categoryPage` component's property. 
* **categories** - a list of showcase categories loaded from the database.
* **currentCategorySlug** - slug of the current category. This property is used for marking the current category in the category list.

The component can be used on any page. The next example shows the basic component usage on the showcase home page:

    title = "Showcase"
    url = "/showcase/:page?"

    [showcaseCategories]
    ==
    ...
    <div class="sidebar">
        {% component 'showcaseCategories' %}
    </div>
    ...

The category list is coded in the default component partial `plugins/rablab/showcase/components/categories/default.htm`.

## Using markdown

October supports [standard markdown syntax](http://daringfireball.net/projects/markdown/) as well as [extended markdown syntax](http://michelf.ca/projects/php-markdown/extra/)

### Classes and IDs

Classes and IDs can be added to images and other elements as shown below:

```
[link](url){#id .class}
![1](image){#id .class}
# October  {#id .class}
```

### Fenced code showcases

Markdown extra makes it possible to use fenced code blocks. With fenced code blocks you do not need indentation on the areas you want to mark as code:


    ```
    Code goes here
    ```
    
You can also use the `~` symbol:

    ~~~
    Code goes here
    ~~~

### Tables

A *simple* table can be defined as follows:

```
First Header  | Second Header
------------- | -------------
Content Cell  | Content Cell 
Content Cell  | Content Cell 
```

If you want to you can also add a leading and tailing pipe:

```
| First Header  | Second Header |
| ------------- | ------------- |
| Content Cell  | Content Cell  |
| Content Cell  | Content Cell  |
```

To add alignment to the cells you simply need to add a `:` either at the start or end of a separator:

```
| First Header  | Second Header |
| :------------ | ------------: |
| Content Cell  | Content Cell  |
| Content Cell  | Content Cell  |
```

To center align cell just add `:` on both sides:

```
| First Header  | Second Header |
| ------------- | :-----------: |
| Content Cell  | Content Cell  |
| Content Cell  | Content Cell  |
```

### Definition lists

Below is an example of a simple definition list:

```
Laravel
:   A popular PHP framework

October
:   Awesome CMS built on Laravel
```

A term can also have multiple definitions:

```
Laravel
:   A popular PHP framework

October
:   Awesome CMS built on Laravel
:   Supports markdown extra
```

You can also associate more than 1 term to a definition:

```
Laravel
October
:   Built using PHP
```

### Footnotes

With markdown extra it is possible to create reference style footnotes:

```
This is some text with a footnote.[^1]

[^1]: And this is the footnote.
```

### Abbreviations

With markdown extra you can add abbreviations to your markup. The use this functionality first create a definition list:

```
*[HTML]: Hyper Text Markup Language
*[PHP]:  Hypertext Preprocessor
```

Now markdown extra will convert all occurrences of `HTML` and `PHP` as follows:

```
<abbr title="Hyper Text Markup Language">HTML</abbr>
<abbr title="Hypertext Preprocessor">PHP</abbr>
```
