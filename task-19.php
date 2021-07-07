<?php
/*
`XIX` Задача о поиске элемента ⭐⭐

Дан упорядоченный массив чисел размером `N`
Нужно реализовать алгоритм поиска вхождения упорядоченного
подмассива размера `M`, где `M << N`

```
func isInclude(array int[], subarray []int) bool

assert(isInclude([1, 2, 3, 5, 7, 9, 11], []) == true)
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [3, 5, 7]) == true)
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [4, 5, 7]) == false)
```

Что хочется увидеть:
1. Алгоритм со сложностью быстрее чем `O(N)` по времени
*/

declare(strict_types = 1);

const INDEX_NOT_FOUND = -1;

function isInclude(array $array, array $subArray): bool
{
    if (empty($subArray)) {
        return true;
    }

    if (empty($array)) {
        return false;
    }

    $subArrayLength = count($subArray);
    $searchValue = $subArray[0];
    $startIndex = binarySearch($array, $searchValue, $subArrayLength);
    if ($startIndex === INDEX_NOT_FOUND) {
        return false;
    }

    $arrayLength = count($array);
    $isIncluded = false;
    while (
        ! $isIncluded
        && $array[$startIndex] === $searchValue
        && isEnoughItemsLeft($arrayLength, $subArrayLength, $startIndex)
    ) {
        $isIncluded = checkInclusionFromIndex($array, $subArray, $startIndex);
        $startIndex++;
    }

    return $isIncluded;
}

function binarySearch(array $array, int $searchValue, int $subArrayLength): int
{
    $arrayLength = count($array);
    $start = 0;
    $end = $arrayLength;
    while ($start < $end) {
        $mean = $start + (int) floor(($end - $start) / 2);
        if ($array[$mean] < $searchValue) {
            $start = $mean + 1;
            if (! isEnoughItemsLeft($arrayLength, $start, $subArrayLength)) {
                return INDEX_NOT_FOUND;
            }
        } else {
            $end = $mean;
        }
    }
    return ($array[$start] === $searchValue) ? $start : INDEX_NOT_FOUND;
}

function isEnoughItemsLeft(int $arrayLength, int $subArrayLength, int $startIndex): bool
{
    return $arrayLength - $startIndex >= $subArrayLength;
}

function checkInclusionFromIndex(array $array, array $subArray, int $startIndex): bool
{
    $i = 0;
    foreach ($subArray as $subArrayItem) {
        if ($subArrayItem !== $array[$startIndex + $i]) {
            return false;
        }
        $i++;
    }
    return true;
}

//=========================================================================================

assert(isInclude([1, 2, 3, 5, 7, 9, 11], []) === true);
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [3, 5, 7]) === true);
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [4, 5, 7]) === false);
assert(isInclude([], []) === true);
assert(isInclude([], [1, 2]) === false);
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [7, 9]) === true);
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [13]) === false);
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [-1]) === false);
assert(isInclude([1, 2, 3, 5, 7, 9, 11], [5]) === true);
assert(isInclude([1, 2, 2, 2, 7, 9, 11], [2, 7, 9]) === true);
assert(isInclude([1, 2, 2, 2, 7, 9, 11], [2, 2]) === true);
assert(isInclude([0, 3, 3, 4, 5], [3, 3, 4, 5]) === true);
assert(isInclude([0, 3, 3, 3, 5], [3, 3, 4, 5]) === false);
