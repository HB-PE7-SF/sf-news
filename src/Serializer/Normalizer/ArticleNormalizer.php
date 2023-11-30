<?php

namespace App\Serializer\Normalizer;

use App\Entity\Article;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ArticleNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if (!$object instanceof Article) {
            return $data;
        }

        $data['url'] = $this->urlGenerator->generate(
            'article_item',
            ['id' => $object->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Article;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
