/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

const bootstrapPluginSelectors =
    '[data-toggle="tooltip"], [data-toggle="popover"]';
const bootstrapPluginAttributes = [
    "data-toggle",
    "data-content",
    "data-placement",
    "data-trigger",
    "data-html",
    "data-delay",
    "data-animation",
    "data-template",
    "data-offset",
    "data-container",
];
const templateWidgetSelectors =
    ".summernote, .summernote-simple, [data-width], [data-height], [data-confirm]";
const bootstrapPluginsToRefresh = new WeakSet();

const initializeBootstrapPlugins = (root = document) => {
    $(root)
        .find(bootstrapPluginSelectors)
        .addBack(bootstrapPluginSelectors)
        .each(function () {
            const element = $(this);

            if (this.matches('[data-toggle="tooltip"]')) {
                if (!element.data("bs.tooltip")) {
                    element.tooltip();
                }
            }

            if (this.matches('[data-toggle="popover"]')) {
                if (!element.data("bs.popover")) {
                    element.popover({ container: "body" });
                }
            }
        });
};

const refreshBootstrapPlugin = (element) => {
    const plugin = $(element);

    if (plugin.data("bs.tooltip")) {
        plugin.tooltip("dispose");
    }

    if (plugin.data("bs.popover")) {
        plugin.popover("dispose");
    }

    initializeBootstrapPlugins(element);
};

const disposeBootstrapPlugins = (root) => {
    $(root)
        .find(bootstrapPluginSelectors)
        .addBack(bootstrapPluginSelectors)
        .each(function () {
            const element = $(this);

            if (element.data("bs.tooltip")) {
                element.tooltip("dispose");
            }

            if (element.data("bs.popover")) {
                element.popover("dispose");
            }
        });
};

const initializeTemplateWidgets = (root = document) => {
    $(root)
        .find(templateWidgetSelectors)
        .addBack(templateWidgetSelectors)
        .each(function () {
            const element = $(this);

            if (this.matches(".summernote, .summernote-simple")) {
                if (!element.data("summernote")) {
                    element.summernote(
                        this.matches(".summernote-simple")
                            ? {
                                  dialogsInBody: true,
                                  minHeight: 150,
                                  toolbar: [
                                      [
                                          "style",
                                          [
                                              "bold",
                                              "italic",
                                              "underline",
                                              "clear",
                                          ],
                                      ],
                                      ["font", ["strikethrough"]],
                                      ["para", ["paragraph"]],
                                  ],
                              }
                            : {
                                  dialogsInBody: true,
                                  minHeight: 250,
                              },
                    );
                }
            }

            if (this.hasAttribute("data-width")) {
                element.css("width", element.data("width"));
            }

            if (this.hasAttribute("data-height")) {
                element.css("height", element.data("height"));
            }

            if (this.hasAttribute("data-confirm")) {
                if (element.hasClass("fire-modal-initialized")) {
                    return;
                }

                const [title, body] = String(element.data("confirm")).split(
                    "|",
                );

                element.addClass("fire-modal-initialized").fireModal({
                    title,
                    body,
                    buttons: [
                        {
                            text: element.data("confirm-text-yes") || "Yes",
                            class: "btn btn-danger btn-shadow",
                            handler: () => {
                                eval(element.data("confirm-yes"));
                            },
                        },
                        {
                            text:
                                element.data("confirm-text-cancel") || "Cancel",
                            class: "btn btn-secondary",
                            handler: (modal) => {
                                $.destroyModal(modal);
                                eval(element.data("confirm-no"));
                            },
                        },
                    ],
                });
            }
        });
};

const disposeTemplateWidgets = (root) => {
    $(root)
        .find(".summernote, .summernote-simple")
        .addBack(".summernote, .summernote-simple")
        .each(function () {
            const element = $(this);

            if (element.data("summernote")) {
                element.summernote("destroy");
            }
        });
};

const registerLivewireUiHooks = () => {
    if (!window.Livewire || registerLivewireUiHooks.registered) {
        return;
    }

    registerLivewireUiHooks.registered = true;

    Livewire.hook("morph.added", ({ el }) => initializeBootstrapPlugins(el));
    Livewire.hook("morph.added", ({ el }) => initializeTemplateWidgets(el));
    Livewire.hook("morph.updating", ({ el, toEl }) => {
        if (
            !el.matches(bootstrapPluginSelectors) &&
            !toEl.matches(bootstrapPluginSelectors)
        ) {
            return;
        }

        if (
            bootstrapPluginAttributes.some(
                (attribute) =>
                    el.getAttribute(attribute) !== toEl.getAttribute(attribute),
            ) ||
            (el.getAttribute("title") ??
                el.getAttribute("data-original-title")) !==
                (toEl.getAttribute("title") ??
                    toEl.getAttribute("data-original-title"))
        ) {
            bootstrapPluginsToRefresh.add(el);
        }
    });
    Livewire.hook("morph.updated", ({ el }) => {
        if (!bootstrapPluginsToRefresh.has(el)) {
            return;
        }

        bootstrapPluginsToRefresh.delete(el);
        refreshBootstrapPlugin(el);
    });
    Livewire.hook("morph.removing", ({ el }) => {
        disposeBootstrapPlugins(el);
        disposeTemplateWidgets(el);
    });
};

if (window.Livewire) {
    registerLivewireUiHooks();
} else {
    document.addEventListener("livewire:init", registerLivewireUiHooks, {
        once: true,
    });
}

document.addEventListener("livewire:navigated", () => {
    initializeBootstrapPlugins();
    initializeTemplateWidgets();
});
document.addEventListener("livewire:navigating", () => {
    $(".dropdown-list-icons").getNiceScroll().remove();
    disposeBootstrapPlugins(document);
    disposeTemplateWidgets(document);
});

initializeBootstrapPlugins();

$(document)
    .on("shown.bs.dropdown", ".dropdown-list-toggle", function () {
        $(this).find(".dropdown-list-icons").niceScroll({
            cursoropacitymin: 0.3,
            cursoropacitymax: 0.8,
            cursorwidth: 7,
        });
    })
    .on("hidden.bs.dropdown", ".dropdown-list-toggle", function () {
        $(this).find(".dropdown-list-icons").getNiceScroll().remove();
    });
