<?php

namespace Mbsoft\Rewards\Enums;

enum ProgramType: string
{
    case POINT_BASED = 'point-based';
    case GAMIFIED = 'gamified';
    case TIERED = 'tiered';
    case GENERIC = 'generic';
}
