class LeftMenu {
    static get DataKey() {
        return "lte.pushmenu"
    };

    static get Default() {
        return {
            collapseScreenSize: 767,
            isAnimation: true,
            isCollapsed: false,
            callbacks: {
                init: () => {},
                open: () => {},
                close: () => {}
            }
        }
    }

    static get Selector() {
        return {
            collapsed: ".sidebar-collapse",
            open: ".sidebar-open",
            mainSidebar: ".main-sidebar",
            contentWrapper: ".content-wrapper",
            button: '[data-toggle="push-menu"]',
            mini: ".sidebar-mini",
            layoutFixed: ".fixed"
        }
    }

    static get ClassName() {
        return {
            collapsed: "sidebar-collapse",
            open: "sidebar-open",
            mini: "sidebar-mini",
            layoutFixed: "fixed",
            holdTransition: "hold-transition"
        }
    }

    static get Event() {
        return {
            expanded: "expanded.pushMenu",
            collapsed: "collapsed.pushMenu"
        }
    }


    constructor(options = {}) {
        this.options = {
            ...LeftMenu.Default,
            ...options
        };
        this.init();
    }

    init() {
        if (!this.options.isAnimation) {
            $("body").addClass(LeftMenu.ClassName.holdTransition);
        } else {
            $("body").removeClass(LeftMenu.ClassName.holdTransition);
        }

        if (this.options.isCollapsed) {
            $("body").addClass(LeftMenu.ClassName.collapsed);
        }

        $(document).on('click', LeftMenu.Selector.contentWrapper,
            function () {
                // Enable hide menu when clicking on the content-wrapper on small screens
                if (
                    $(window).width() <= this.options.collapseScreenSize &&
                    $("body").hasClass(LeftMenu.ClassName.open)
                ) {
                    this.close();
                }
            }.bind(this)
        );

        this.options.callbacks.init(this);
    }

    toggle() {
        let windowWidth = $(window).width();
        let isOpen = !$("body").hasClass(LeftMenu.ClassName.collapsed);

        if (windowWidth <= this.options.collapseScreenSize) {
            isOpen = $("body").hasClass(LeftMenu.ClassName.open);
        }

        if (!isOpen) {
            this.open();
        } else {
            this.close();
        }
    }

    open() {
        let windowWidth = $(window).width();

        if (windowWidth > this.options.collapseScreenSize) {
            $("body")
                .removeClass(LeftMenu.ClassName.collapsed)
                .trigger(LeftMenu.Event.expanded);
        } else {
            $("body")
                .addClass(LeftMenu.ClassName.open)
                .trigger(LeftMenu.Event.expanded);
        }

        this.options.callbacks.open(this);
    }

    close() {
        let windowWidth = $(window).width();
        if (windowWidth > this.options.collapseScreenSize) {
            $("body")
                .addClass(LeftMenu.ClassName.collapsed)
                .trigger(LeftMenu.Event.collapsed);
        } else {
            $("body")
                .removeClass(LeftMenu.ClassName.open + " " + LeftMenu.ClassName.collapsed)
                .trigger(LeftMenu.Event.collapsed);
        }

        this.options.callbacks.close(this);
    }

    static _bind(option) {
        return this.each(function () {
            let $this = $(this);
            let data = $this.data(LeftMenu.DataKey);
            if (!data) {
                let options = $.extend(
                    {},
                    LeftMenu.Default,
                    $this.data(),
                    typeof option === "object" && option
                );
                $this.data(LeftMenu.DataKey, (data = new LeftMenu(options)));
            }
            if (option === "toggle") data.toggle();
        });
    }

    static bind() {
        $(document).on("click", LeftMenu.Selector.button, function (e) {
            e.preventDefault();
            LeftMenu._bind.call($(this), "toggle");
        });
    }

    static unBind() {
        $(document).off("click", LeftMenu.Selector.button);
        $(LeftMenu.Selector.button).removeData("lte.pushmenu");
    }

}

export default LeftMenu;