# Showcase Plugin

Provides a showcase plugin, can be used to show products, services or until like a photos gallery.

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