<?php

namespace App\Infrastructure\Extension\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigAssetExtension extends AbstractExtension
{
    final const CACHE_KEY = 'asset_time';
    private bool $isProduction;
    private ?array $paths = null;

    public function __construct
    (
        private string $assetPath,
        private string $env,
        private RequestStack $requestStack,
        private CacheInterface $cache,
    ){
        $this->isProduction = 'prod' === $env;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('encore_entry_link_tags', $this->link(...), ['is_safe' => ['html']]),
            new TwigFunction('encore_entry_script_tags', $this->script(...), ['is_safe' => ['html']])
        ];
    }

    public function link(string $name, ?array $attrs = []): string
    {
        $uri = $this->uri($name.'.css');

        if (strpos($uri, ':5173')) {
            return ''; // Le css est injecté dans le js dans l'environnement de dev
        }

        $attributes = implode(' ', array_map(fn($key) => "{$key}=\"{$attrs[$key]}\"", array_keys($attrs)));

        return sprintf(
            '<link rel="stylesheet" href="%s" %s>',
            $uri,
            empty($attrs) ? '' : (' '.$attributes)
        );
    }

    public function script(string $name): string
    {
        $script = $this->preload($name).'<script src="'.$this->uri($name.'.ts').'" type="module" defer></script>';
        if (!$this->isProduction) {
            $script .= <<<HTML
                <script>
                    window.__vite_plugin_react_preamble_installed__ = true
                </script>
            HTML;
        }
        return $script;
    }

    /**
     * Génère l'URL associé à un asset passé en paramètre.
     *
     * @param string $name Le nom du fichier à charger ("app.js" par exemple)
     */
    private function uri(string $name): string
    {
        if (!$this->isProduction) {
            $request = $this->requestStack->getCurrentRequest();

            return $request ? "http://{$request->getHost()}:5173/{$name}" : '';
        }

        if (strpos('.css', $name)) {
            $name = $this->getAssetPaths()[str_replace('.css', '.js', $name)]['css'][0] ?? '';
        } else
            $name = $this->getAssetPaths()[$name]['file'] ?? $this->getAssetPaths()[$name] ?? '';
        ;

        return "/assets/$name";
    }

    private function preload(string $name): string
    {
        $imports = $this->getAssetPaths()[$name]['imports'] ?? [];
        $preloads = [];

        foreach($imports as $import) {
            $preloads[] = <<<HTML
                <link rel="modulepreload" href="{$this->uri($import)}">
            HTML;
        }

        return implode('\n', $preloads);
    }

    private function getAssetPaths(): array
    {
        if (null === $this->paths) {
            $this->paths = $this->cache->get(self::CACHE_KEY, function() {
                $manifest = $this->assetPath.'/manifest.json';
                if (file_exists($manifest)) {
                    return json_decode((string) file_get_contents($manifest), true, 512, JSON_THROW_ON_ERROR);
                } else
                    return [];
            });

            return $this->paths;
        }

        return $this->paths;
    }
}