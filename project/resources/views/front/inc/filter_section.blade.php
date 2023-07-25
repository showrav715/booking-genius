<div class="item-filter">
    <ul class="filter-list">
        <li class="item-short-area">
            <p>{{__('Short By')}} :</p>
            <select class="short-item" id="sort_by" name="sort_by">
                <option value="latest" selected>{{__('Newest')}}</option>
                <option value="oldest">{{__('Oldest')}}</option>
                <option value="price_up">{{__('Price Up')}}</option>
                <option value="price_down">{{__('Price Down')}}</option>
            </select>
        </li>
        <li class="viewitem-no-area">
            <p>{{__('View')}} :</p>
            <select class="short-itemby-no" id="view_count" name="view_count">
                <option value="">{{__('Select Number')}}</option>
                <option value="10" {{request()->input('view') == 10 ? 'selected' : ''}} >10</option>
                <option value="20" {{request()->input('view') == 20 ? 'selected' : ''}}>20</option>
                <option value="30" {{request()->input('view') == 30 ? 'selected' : ''}}>30</option>
            </select>
        </li>
    </ul>
</div>