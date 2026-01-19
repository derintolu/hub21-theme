Directives
data-wp-router-region
It defines a region that is updated on navigation. It requires a unique ID as the value and can only be used in root interactive elements, i.e., elements with data-wp-interactive that are not nested inside other elements with data-wp-interactive.

The value can be a string with the region ID, or a JSON object containing the id and an optional attachTo property.

Example:

<div data-wp-interactive="myblock" data-wp-router-region="main-list">
  <ul>
     <li><a href="/post-1">Post 1</a></li>
     <li><a href="/post-2">Post 2</a></li>
     <li><a href="/post-3">Post 3</a></li>
  </ul>
  <a data-wp-on--click="actions.navigate" href="/page/2">Page 2</a>
</div>
The attachTo property is a CSS selector that points to the parent element where the new router region should be rendered. This is useful for regions that may not exist on the initial page but are present on subsequent pages, like a modal or an overlay.

When navigating between pages:

If a region exists on both the current and the new page, its content is updated. attachTo is ignored in this case.
If a region without attachTo exists on the new page but not on the current one, it is not added to the DOM.
If a region with attachTo exists on the new page but not on the current one, it is created and appended to the parent element specified in attachTo.
If a region exists on the current page but not on the new one, it is removed from the DOM. attachTo is ignored in this case.
Example with attachTo:

<div
  data-wp-interactive="myblock"
  data-wp-router-region='{ "id": "myblock/overlay", "attachTo": "body" }'
>
  I'm in a new region!
</div>
Actions
navigate
Navigates to the specified page.

This function normalizes the passed href, fetches the page HTML if needed, and updates any interactive regions whose contents have changed in the new page. It also creates a new entry in the browser session history.

Params

navigate( href: string, options: NavigateOptions = {} )
href: The page href.
options: Options object.
force: If true, it forces re-fetching the URL. navigate() always caches the page, so if the page has been navigated to before, it will be used. Default is false.
html: HTML string to be used instead of fetching the requested URL.
replace: If true, it replaces the current entry in the browser session history. Default is false.
timeout: Time until the navigation is aborted, in milliseconds. Default is 10000.
loadingAnimation: Whether an animation should be shown while navigating. Default to true.
screenReaderAnnouncement: Whether a message for screen readers should be announced while navigating. Default to true.
prefetch
Prefetches the page for the passed URL. The page is cached and can be used for navigation.

The function normalizes the URL and stores internally the fetch promise, to avoid triggering a second fetch for an ongoing request.

Params

prefetch( url: string, options: PrefetchOptions = {} )
url: The page url.
options: Options object.
force: If true, forces fetching the URL again.
html: HTML string to be used instead of fetching the requested URL.
State
state.url is a reactive property synchronized with the current URL.
Properties under state.navigation are meant for loading bar animations.

Installation
Install the module:

npm install @wordpress/interactivity-router --save
This step is only required if you use the Interactivity API outside WordPress.

Within WordPress, the package is already bundled in Core. To ensure it’s enqueued, add @wordpress/interactivity-router to the dependency array of the script module. This process is often done automatically with tools like wp-scripts.

Furthermore, this package assumes your code will run in an ES2015+ environment. If you’re using an environment with limited or no support for such language features and APIs, you should include the polyfill shipped in @wordpress/babel-preset-default in your code.

