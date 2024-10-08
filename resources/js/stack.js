export default function (Alpine) {
    Alpine.directive('stack', (el, {}, { cleanup }) => {
        let setStackSpaceCollapse = () => {
            el.querySelectorAll('[class*="stack-space-collapse"]').forEach(el => {
                el.setAttribute('data-stack-space-collapse', getComputedStyle(el).getPropertyValue('--stack-space-collapse') || 'false');
            });
        };

        setStackSpaceCollapse();

        window.addEventListener('resize', setStackSpaceCollapse);

        cleanup(() => {
            window.removeEventListener('resize', setStackSpaceCollapse)
        })
    })
}
